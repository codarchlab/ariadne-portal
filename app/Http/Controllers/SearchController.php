<?php

namespace App\Http\Controllers;
use App\Services\SimpleSearch;
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
        $type = null;
        $input = Request::all();
         
        $query = array('match' => array('title' => $input['q']));
        $result = ElasticSearch::search($query);

        return view('search.simpleSearch')
                ->with('type', $type)
                ->with('total', $result['total'])
                ->with('hits', $result['hits']);
     }     
     
    /**
     * Display a listing of the services.
     *
     * @return Response
     */
    public function byType($type) {
        $query = array('match' => array('title' => 'historical'));
        $result = ElasticSearch::search($query, 'dataresources', $type);

        return view('search.simpleSearch')
                ->with('type', $type)
                ->with('total', $result['total'])
                ->with('hits', $result['hits']);
    }


}