<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Config;
use App\Services\ElasticSearch;
use App\Services\DataResource;
use App\Services\Utils;
use Request;

class ResourceController extends Controller {


    public function index() {
        return view('resource.search');
    }

    /**
     * Filters out the spatial items which can be shown on a map.
     *
     * @param $resource
     * @return array of item from the spatial array which have
     *   a location property.
     */
    private function getValidGeoItems($resource) {
        $spatialItems = array();

        if (!array_key_exists('spatial',$resource['_source']))
            return $spatialItems;

        foreach ($resource['_source']['spatial'] as $spatialItem){
            if (!array_key_exists('location',$spatialItem))
                continue;
            array_push($spatialItems,$spatialItem);
        }

        return $spatialItems;
    }

    private function getNearbySpatialItems($type, $spatialItem) {

        $nearbySpatialItems = array();

        foreach (ElasticSearch::geoDistanceQuery('resource', $type, $spatialItem['location'])
                 as $nearbyResource) {

            foreach ($this->getValidGeoItems($nearbyResource)
                     as $validNearbySpatialItem) {
                array_push($nearbySpatialItems,$validNearbySpatialItem);
            }
        }

        return $nearbySpatialItems;
    }

    /**
     * Display the specified resource.
     *
     * @param string $type the elasticsearch type
     * @param  int  $id
     * @return View
     */
    public function show($type,$id) {

        $resource = ElasticSearch::get($id, 'resource', $type);

        $spatial_items = $this->getValidGeoItems($resource);
        $nearby_spatial_items = null;
        if (!empty($spatial_items)) {
            $nearby_spatial_items = $this->getNearbySpatialItems($type, $spatial_items[0]);
        }

        $similar_resources = ElasticSearch::thematicallySimilarQuery($resource);

        return view('resource.show')
            ->with('resource', $resource)
            ->with('geo_items', $spatial_items)
            ->with('nearby_geo_items', $nearby_spatial_items)
            ->with('similar_resources', $similar_resources);
    }

    /**
     * Performs a faceted search depending on the GET-values
     * Eg ?q=dig&keyword=england does a free text search for dig in
     * resources where the keyword england exists
     *
     * @return View rendered pagination for search results
     */
    public function search() {
        $query = ['aggregations' => Config::get('app.elastic_search_aggregations')];

        // add geogrid aggregation
        $ghp = Request::has('ghp') ? Request::input('ghp') : 2;
        $query['aggregations']['geogrid'] = ['geohash_grid' => [
            'field' => 'spatial.location', 'precision' => intval($ghp) 
        ]];

        $q = ['match_all' => []];
        if (Request::has('q')) {
            $q = ['query_string' => ['query' => Request::get('q')]];
        }
        $innerQuery = ['bool' => ['must' => $q]];

        foreach ($query['aggregations'] as $key => $aggregation) {
            if (Request::has($key)) {
                $values = Utils::getArgumentValues($key);

                $field = $aggregation['terms']['field'];

                foreach ($values as $value) {
                    $fieldQuery = [];
                    $fieldQuery[$field] = $value;
                    $innerQuery['bool']['must'][] = ['match' => $fieldQuery];
                }
            }
        }

        // TODO: refactor so that ES service takes care of bbox parsing
        if (Request::has('bbox')) {
            $bbox = explode(',', Request::input('bbox'));
            $query['query'] = [
                'filtered' => [
                    'query' => $innerQuery,
                    'filter' => [
                        'geo_bounding_box' => [
                            'spatial.location' => [
                                'top_left' => [
                                    'lat' => floatval($bbox[3]),
                                    'lon' => floatval($bbox[0])
                                ],                                
                                'bottom_right' => [
                                    'lat' => floatval($bbox[1]),
                                    'lon' => floatval($bbox[2])
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $query['query'] = $innerQuery;
        }

        $hits = ElasticSearch::search($query, 'resource');

        if (Request::wantsJson()) {
            return response()->json($hits);
        } else {
            return view('resource.search')
                ->with('type', null)
                ->with('aggregations', $query['aggregations'])
                ->with('translateAggregations', Config::get('app.translate_aggregations'))
                ->with('hits', $hits);
        }
    }
}
