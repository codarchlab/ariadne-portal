<?php

namespace App\Http\Controllers;

use Request;
use Input;
use \App\Services\Map;

class MapController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index() {
        $points = Map::all();        
        //dd($points);
        return view('map.index')->with('points', $points);
    }
    
    public function results() {
        if(Request::ajax()) {
           $data = Input::all();    
           
           $resources = Map::searchResults($data);           
           return $resources;
        }       
    }
    
     
}
