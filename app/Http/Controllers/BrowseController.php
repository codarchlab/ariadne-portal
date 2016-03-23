<?php

namespace App\Http\Controllers;

use Request;
use Input;
use App\Services\Map;
use App\Services\ElasticSearch;
use App\Services\Utils;

class BrowseController extends Controller {

    /**
     * Performs a faceted search depending on the GET-values
     * Eg ?q=dig&keyword=england does a free text search for dig in
     * resources where the keyword england exists
     *
     * @return View rendered pagination for search results
     */
    public function where() {
        return view('browse.where');
    }  


    public function when() {
        return view('browse.when');
    }
    
    public function what() {
      $cloudData = Utils::getWordCloudData();
      return view('browse.what') 
          ->with('cloud_data', $cloudData);
    }
    
}
