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
        return view('browse.map');
    }  
     
}
