<?php

namespace App\Http\Controllers;
use App\Services\SimpleSearch;
use Request;

class SearchController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the services.
     *
     * @return Response
     */
    public function index($typeId) {
        $type= SimpleSearch::getType($typeId);
        //dd($type);
        
        $drs= SimpleSearch::getDataResources('arcaeol');
        //dd($drs);
        return view('search.simpleSearch')->with('type', $type)->with('drs', $drs);
    }

    /**
      * Display a listing of the services.
      *
      * @return Response
      */
     public function search() {
         
         $input = Request::all();
         
         //TODO Process search string and return results
     }
}