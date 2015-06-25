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
        return view('search.simpleSearch');
     }    
    
    public function search() {
        $input = Request::all();
        if(Request::has('q')){
            $query = ['query' => [
                            'match' => ['_all' => $input['q']]
                        ],
                        'aggregations' => [
                            'keyword'  => ['terms' => ['field' => 'keyword']],
                            'rights'   => ['terms' => ['field' => 'rights']],
                            'language' => ['terms' => ['field' => 'language']]
                        ] 
                    ];
        }else{
            $query = ['query'=> [
                          'match' => ['_all' => '*']
                        ]
                     ];
        }
        
        $hits = ElasticSearch::search($query);
        //dd($hits);
        debug("aggregations", $hits->aggregations);
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
                          ['multi_match' => [
                              'query' => $input['q'],
                              'type' => 'most_fields',
                              'fields' => [
                                            'title', 
                                            'keyword', 
                                            'subject',
                                            'description',
                                            'creator'
                                          ]
                          ]]
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