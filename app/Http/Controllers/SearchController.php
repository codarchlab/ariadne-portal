<?php

namespace App\Http\Controllers;

use App\Services\ElasticSearch;
use Utils;
use Request;
use Illuminate\Support\Facades\Config;

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
        $query = ['aggregations' => Config::get('app.aggregations')];
        
        if(Request::has('q')){
            $q = ['query_string' => ['query' => Request::get('q')]];
            $query['query']['bool']['must'][] = $q;
        }
        
        foreach($query['aggregations'] as $key => $aggregation){
           if(Request::has($key)){
               $values = Utils::getArgumentValues($key);
               
               $field = $aggregation['terms']['field'];

               foreach($values as $value){
                    $fieldQuery = [];
                    $fieldQuery[$field] = $value;
                    $query['query']['bool']['must'][] = ['match' => $fieldQuery];
               }
               
           }
        }       

        $hits = ElasticSearch::search($query, 'resource');

        return view('search.simpleSearch')
                ->with('type', null)
                ->with('aggregations', $query['aggregations'])
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