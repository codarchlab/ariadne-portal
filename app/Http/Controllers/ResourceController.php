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
     * Filters out the items which can be shown on a map.
     *
     * @param $resource
     * @return array of item from the spatial array which have
     *   a location property.
     */
    private function getValidGeoItems($resource) {
        $geo_items = array();
        if (!array_key_exists('spatial',$resource['_source']))
            return $geo_items;

        foreach ($resource['_source']['spatial'] as $spatial){
            if (!array_key_exists('location',$spatial))
                continue;
            $location=$spatial['location'];
            array_push($geo_items,$location);
        }

        return $geo_items;
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
        $geo_items = $this->getValidGeoItems($resource);

        return view('resource.show')
            ->with('resource', $resource)
            ->with('geo_items', $geo_items);
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

        if (Request::has('q')) {
            $q = ['query_string' => ['query' => Request::get('q')]];
            $query['query']['bool']['must'][] = $q;
        }

        foreach ($query['aggregations'] as $key => $aggregation) {
            if (Request::has($key)) {
                $values = Utils::getArgumentValues($key);

                $field = $aggregation['terms']['field'];

                foreach ($values as $value) {
                    $fieldQuery = [];
                    $fieldQuery[$field] = $value;
                    $query['query']['bool']['must'][] = ['match' => $fieldQuery];
                }
            }
        }

        $hits = ElasticSearch::search($query, 'resource');

        return view('resource.search')
            ->with('type', null)
            ->with('aggregations', $query['aggregations'])
            ->with('translateAggregations', Config::get('app.translate_aggregations'))
            ->with('hits', $hits);
    }
}
