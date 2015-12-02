<?php
namespace App\Services;

use Config;
use Request;
use Illuminate\Pagination\Paginator;
use App\Pagination\ElasticSearchPaginator;

class ElasticSearch {

    private static $client = NULL;
    
    /**
     * Get a client to perform rest request to Elastic Search
     * 
     * @return Object Elastic Search client
     */
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
            return $result;
        }else{
            throw new Exception('No document found by id: '.$id);
        }
    }

    /**
     * @param $index
     * @param $type
     * @param $location must have keys and values for lat and lon.
     * @return resources within a range of x km of $location.
     */
    public static function geoDistanceQuery($index, $type, $location) {

        $json = '{
            "query" : {

                "filtered" : {
                  "query" : {
                      "match_all" : {}
                  },
                  "filter" : {
                      "geo_distance" : {
                          "distance" : "20km",
                          "spatial.location" : {
                              "lat" : '.$location['lat'].',
                              "lon" : '.$location['lon'].'
                          }
                      }
                  }
              }
            }
        }';

        $params = [
            'index' => $index,
            'type' => $type,
            'body' => $json
        ];

        $result = self::getClient()->search($params);
        return $result['hits']['hits'];
    }


    /**
     * @param $resource
     * @return the seven most similar resources based on subjects & time periods
     */
    public static function thematicallySimilarQuery($resource) {

      $json = '{
        "query": {
          "bool": {
            "must_not": {
              "match": {
                "_id": "' . $resource['_id'] .  '"
              }
            },
            "should": [';

      $firstMatch = true;

      if (array_key_exists('nativeSubject', $resource['_source'])) {
        foreach ($resource['_source']['nativeSubject'] as $subject) {
          if (!array_key_exists('prefLabel', $subject))
            continue;

          if ($firstMatch)
            $firstMatch = false;
          else
            $json .= ',';

          $json .= '{
              "match": {
                "nativeSubject.prefLabel": "' . $subject['prefLabel'] . '"
              }
            }';
        }
      }

      if (array_key_exists('temporal', $resource['_source'])) {
        foreach ($resource['_source']['temporal'] as $temporal) {
          if (!array_key_exists('periodName', $temporal))
            continue;

          if ($firstMatch)
            $firstMatch = false;
          else
            $json .= ',';

          $json .= '{
              "match": {
                "temporal.periodName": "' . $temporal['periodName'] . '"
              }
            }';
        }
      }
        
      $json .= '],
              "minimum_should_match" : 1
            }
          }
        }';

      $params = [
            'index' => 'resource',
            'size' => 7,
            'body' => $json
        ];

        $result = self::getClient()->search($params);
        return $result['hits']['hits'];
    }


    
    /**
     * Performs a paginated search against Elastic Search
     * 
     * @param Array $query Array containing the elastic search query
     * @param string $index Index to search in (optional)
     * @param string $type Type of document to search for (optional)
     * @return LengthAwarePaginator paginated result of the search
     */
    public static function search($query, $index = null, $type = null){
        $perPage = Request::input('perPage', 10);
        $from = $perPage * (Request::input('page', 1) - 1);
        
        $query['highlight'] = array('fields' => array('*' => (object) array()));
        $searchParams = array(
            'body' => $query,
            'size' => $perPage,
            'from' => $from
        );
        
        if($index){
            $searchParams['index'] = $index;
        }
        
        if($type){
            $searchParams['type'] = $type;
        }
        
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        //dd($queryResponse);
        $paginator = new ElasticSearchPaginator(
                            $queryResponse['hits']['hits'],
                            $queryResponse['hits']['total'],
                            $perPage,
                            $queryResponse['aggregations'],
                            Paginator::resolveCurrentPage(),
                            ['path' => Paginator::resolveCurrentPath()]
                        );
        return $paginator;
    }
    
    public static function countHits($query, $index, $type=null){

        $searchParams = array(
            'body' => $query
        );
        
        $searchParams['index'] = $index;
        if ($type) $searchParams['type'] = $type;
   
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        
        //return $queryResponse;
        return $queryResponse['hits']['total'];
    }
    
    
    public static function allHits($query, $index, $type=null){

        $searchParams = array(
            'body' => $query
        );
        
        $searchParams['index'] = $index;
        if ($type) $searchParams['type'] = $type;
   
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        
        //return $queryResponse;
        return $queryResponse['hits']['hits'];
    }
    
    public static function allResourcePaginated($query, $index, $type=null){
        
        $perPage = Request::input('perPage', 15);
        $from = $perPage * (Request::input('page', 1) - 1);
        
        $searchParams = array(
            'body' => $query,
            'size' => $perPage,
            'from' => $from
        );
        
        $searchParams['index'] = $index;
        if ($type) $searchParams['type'] = $type;
   
        $client = self::getClient();
        
        $queryResponse = $client->search($searchParams);
        
        foreach ($queryResponse['hits']['hits'] as &$obj) {
            $obj['_source']['providerAcro'] = Utils::getProviderName($obj['_source']['providerId']);
        }
        
        $paginator = new LengthAwarePaginator(
                            $queryResponse['hits']['hits'],
                            $queryResponse['hits']['total'],
                            $perPage,
                            Paginator::resolveCurrentPage(),
                            ['path' => Paginator::resolveCurrentPath()]
                        );
       
        return $paginator;
    }
}
