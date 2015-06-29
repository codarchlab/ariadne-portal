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
        
        $aggs = [
                    'subject'  => ['terms' => ['field' => 'subject']],
                    'keyword'  => ['terms' => ['field' => 'keyword']],
                    'archaeologicalResourceType'  => ['terms' => ['field' => 'archaeologicalResourceType']],
                    'publisher'=> ['terms' => ['field' => 'publisher.name']],
                    'rights'   => ['terms' => ['field' => 'rights']],
                    'language' => ['terms' => ['field' => 'language']]
                ];
        
        if(Request::has('q')){
            $query = ['query' => [
                            'match' => [
                                '_all' => $input['q'],
                            ]
                        ],
                        'aggs' => $aggs
                    ];
        }else{
            $query = ['aggs' => $aggs];
        }
        foreach($aggs as $key => $agg){
           if(!empty($input[$key])){
               $values = Utils::getArgumentValues($key);
               
               $field = $agg['terms']['field'];
               
               $query['query']['filtered']['filter']['bool']['must']['term'][$field] = $values;
               
           }
       }       
        debug($query);
        $hits = ElasticSearch::search($query);
        //dd($hits);
        //debug("aggregations", $hits->aggregations);
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