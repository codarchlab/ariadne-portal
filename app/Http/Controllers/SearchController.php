<?php

namespace App\Http\Controllers;

use App\Services\ElasticSearch;
use Utils;
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

    public function index() {
        $type = Utils::getDataResourceType(1);
        $input = Request::all();
         
        $dataResources= SimpleSearch::getDataResources('arcaeol');

        return view('search.simpleSearch')
                ->with('type', $type)
                ->with('drs', $dataResources);
     }    
    
    public function search() {
        $input = Request::all();
        if(Request::has('q')){
            $query = ['query'=>
                          ['match' => ['title' => $input['q']]]
                     ];
        }else{
            $query = ['query'=>
                          ['match' => ['title' => '*']]
                     ];
        }
        
        $hits = ElasticSearch::search($query);

        return view('search.simpleSearch')
                ->with('type', null)
                ->with('hits', $hits);
     }     
     
    /**
     * Display a listing of the services.
     *
     * @return Response
     */
    public function byType($type) {
        $input = Request::all();
        
        if(Request::has('q')){
            $query = ['query'=>
                          ['match' => ['title' => $input['q']]]
                     ];
        }else{
            $query = ['query'=>
                          ['match' => ['title' => '*']]
                     ];
        }
        
        $hits = ElasticSearch::search($query, 'dataresources', $type);
        
        return view('search.simpleSearch')
                ->with('type', $type)
                ->with('hits', $hits);
    }


}