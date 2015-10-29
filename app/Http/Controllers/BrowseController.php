<?php

namespace App\Http\Controllers;

use Request;
use Input;
use App\Services\Map;
use App\Services\ElasticSearch;

class BrowseController extends Controller {

    /**
     * Performs a faceted search depending on the GET-values
     * Eg ?q=dig&keyword=england does a free text search for dig in
     * resources where the keyword england exists
     *
     * @return View rendered pagination for search results
     */
    public function map() {
        $query = [
          'aggregations' => ['geogrid' => ['geohash_grid' => [ 'field' => 'spatial.location', 'precision' => 2 ]]]
        ];

        $result = ElasticSearch::search($query, 'resource');

        return view('browse.map')
            ->with('grid', $result->aggregations()['geogrid']['buckets']);

    }  
     
}
