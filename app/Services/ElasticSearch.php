<?php
namespace App\Services;

use Config;
use Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ElasticSearch {

    private static $client = NULL;
    
    private static function getClient() {
        if ( is_null( self::$client ) ){
            $params = array();
            $params['hosts'] = array (Config::get('app.elastic_search_host'));

            self::$client = new \Elasticsearch\Client($params);
        }
        return self::$client;
    }
    
    /**
     * Get document from Elastic Search
     * 
     * @param type $id id of the document (e.g. dataset id)
     * @param type $index index containing the document
     * @param type $type type of document to look for
     * @return Array all the values in _source from Elastic Search
     * @throws Exception if document is not found
     */
    public static function get($id, $index, $type){
        $getParams = array(
            'id' => $id,
            'index' => $index,
            'type' => $type
        );
        
        $client = self::getClient();
        
        $result = $client->get($getParams);   
        
        if($result['found']){
            return $result['_source'];
        }else{
            throw new Exception('No docuemnt found by id: '.$id);
        }
    }
    
    public static function search($query, $index = null, $type = null){
        $perPage = Request::input('perPage', 10);
        $from = $perPage * (Request::input('page', 1)-1);
        
        $searchParams = array(
            'body' => $query,
            'size' => $perPage,
            'from' => $from
        );

        //dd($searchParams);
        
        if($type){
            $searchParams['index'] = $index;
        }        
        
        if($type){
            $searchParams['type'] = $type;
        }
        
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        
        $paginator = new LengthAwarePaginator(
            $queryResponse['hits']['hits'],
            $queryResponse['hits']['total'],
            10,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]);
        return $paginator;
        dd($paginator);
        
        return $queryResponse['hits'];
    }
}
