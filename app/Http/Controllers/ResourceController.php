<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Services\Resource;
use App\Services\Utils;
use Log;
use Request;
use stdClass;

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

    private function getNearbySpatialItems($spatialItem) {

        $nearbySpatialItems = array();

        foreach (Resource::geoDistanceQuery($spatialItem['location'])
                 as $nearbyResource) {

            foreach ($this->getValidGeoItems($nearbyResource)
                     as $validNearbySpatialItem) {
                array_push($nearbySpatialItems,$validNearbySpatialItem);
            }
        }

        return $nearbySpatialItems;
    }

    private function getCitationLink($resource) {

        // Check if a persistent identifier is specified
        $identifiers = ['doi:', 'hdl:', 'urn:', 'http://', 'https://'];

        if (array_key_exists('originalId', $resource['_source'])) {
            $originalId = $resource['_source']['originalId'];

            foreach ($identifiers as $identifier) {
                if (substr($originalId, 0, strlen($identifier)) === $identifier)
                    return $originalId;
            }
        }

        // Return landing page url if no persistent identifier is given
        if (array_key_exists('landingPage', $resource['_source']))
            return $resource['_source']['landingPage'];

        // Return portal url if no landing page url is given
        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $resource['_type'] . '/' . $resource['_id'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function page($id) {
   
      $resource = Resource::get($id);

      $spatial_items = $this->getValidGeoItems($resource);
      $nearby_spatial_items = null;
      if (!empty($spatial_items)) {
        $nearby_spatial_items = $this->getNearbySpatialItems($spatial_items[0]);
      }

      $similar_resources = Resource::thematicallySimilarQuery($resource);

      $citationLink = $this->getCitationLink($resource);

      $parts_count = null;
      if ($resource['_source']['resourceType'] == 'collection') {
        $parts_count = Resource::getPartsCountQuery($resource);
      }

      $partOf = [];
      if (isset($resource['_source']['isPartOf'])) {
        foreach ($resource['_source']['isPartOf'] as $isPartOf) {
          $isPartOfParts = explode("/", $isPartOf);
          $newThing = new stdClass;
          $newThing->id = end($isPartOfParts);
          $newThing->name = Utils::getResourceTitle(end($isPartOfParts));
          $partOf[] = $newThing;
        }
      }
      
      //Extract id from derived subjects
      if (isset($resource['_source']['derivedSubject'])) {
        foreach ($resource['_source']['derivedSubject'] as &$subject) {
          $subject['id'] = explode("http://vocab.getty.edu/aat/", $subject['source'])[1];
        }
      }

        return view('resource.page', [
        'resource' => $resource,
        'geo_items' => $spatial_items,
        'nearby_geo_items' => $nearby_spatial_items,
        'similar_resources' => $similar_resources,
        'citationLink' => $citationLink,
        'parts_count' => $parts_count,
        'partOf' => $partOf
      ]);
    }

  /**
     * Serialize the specified resource as json.
     *
     * @param  int  $id
     * @return Response response object
     */
    public function json($id) {

        $resource = Resource::get($id);
        return response()->json($resource['_source']);
    }
    
    /**
     * Serialize the specified resource as acdm xml.
     *
     * @param  int  $id
     * @return Response response object
     */
    public function xml($id) {

        $resource = Resource::get($id);
        
        $path = Config::get('app.more_host').'/objects/'.$resource['_source']['packageId'].'/'.$id.'/ACDM/content';       
        
        try{
            $content = file_get_contents($path);
        }
        catch(ErrorException $exception){
            abort(500);
        }
        
        if($content) {        
            header("Content-type: text/xml");
            print($content);
            exit(0);
        }
        else{
            abort(404);
        }
    }

    /**
     * Resolve resource URI to page or data.
     *
     * @param  int  $id
     * @return Redirector redirector
     */
    public function negotiate($id) {

        if (Request::wantsJson()) {
            return redirect()->route('resource.data', [ 'id' => $id ], 303);
        } else {
            return redirect()->route('resource.page', [ 'id' => $id ], 303);
        }
    }

    /**
     * Performs a faceted search depending on the GET-values
     * Eg ?q=dig&keyword=england does a free text search for dig in
     * resources where the keyword england exists
     *
     * @return View rendered pagination for search results
     */
    public function search() {

        Utils::redirectIfEmptySearch();
        
        $query = Resource::getCurrentQuery();

        $hits = Resource::search($query, 'resource');

        if (Request::wantsJson()) {
            return response()
                    ->json($hits)
                    ->header("Vary", "Accept");
        } else {
            return view('resource.search')
                ->with('type', null)
                ->with('aggregations', $query['aggregations'])
                ->with('translateAggregations', Config::get('app.translate_aggregations'))
                ->with('hits', $hits);
        }
    }
}
