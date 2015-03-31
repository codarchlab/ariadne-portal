<?php
namespace App\Services;
use Config;
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
     * @param type $id
     * @param type $index
     * @param type $type
     * @return type
     * @throws Exception
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
        $searchParams = array(
            'body' => array('query' => $query)
        );

        if($type){
            $searchParams['index'] = $index;
        }        
        
        if($type){
            $searchParams['type'] = $type;
        }
        
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        
        return $queryResponse['hits'];
    }
}
