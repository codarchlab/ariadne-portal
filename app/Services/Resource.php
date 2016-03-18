<?php
/**
 * Service for accessing resources in the catalog
 *
 * Wraps access to the elasticsearch index representing the ariadne catalog.
 */

namespace app\Services;

use App\Services\ElasticSearch;
use App\Services\Utils;
use App\Services\Timeline;
use Config;
use Request;


class Resource
{

    const RESOURCE_TYPE = 'resource';

    /**
     * Get a document for a single resource from the catalog index
     *
     * @param type $id id of the document (e.g. dataset id)
     * @return Array all the values in _source from Elastic Search
     * @throws Exception if document is not found
     */
    public static function get($id){
        return ElasticSearch::get($id, Config::get('app.elastic_search_catalog_index'), self::RESOURCE_TYPE);
    }

    /**
     * Performs a paginated search against Elastic Search
     *
     * @param Array $query Array containing the elastic search query
     * @return LengthAwarePaginator paginated result of the search
     */
    public static function search($query) {
        return ElasticSearch::search($query, Config::get('app.elastic_search_catalog_index'), self::RESOURCE_TYPE);
    }
    
    public static function getCurrentQuery(){
        $query = ['aggregations' => Config::get('app.elastic_search_aggregations')];
        
        // add geogrid aggregation
        $ghp = Request::has('ghp') ? Request::input('ghp') : 2;
        $query['aggregations']['geogrid'] = ['geohash_grid' => [
            'field' => 'spatial.location', 'precision' => intval($ghp), 'size' => 20000
        ]];

        // add timespan bucket aggregation
        $query['aggregations']['range_buckets'] = Timeline::prepareRangeBucketsAggregation(
                intval(Request::get("start")), intval(Request::get("end")), 50);
        
        // handle sorting
        if(Request::has('sort') && in_array(Request::input('sort'), Config::get('app.elastic_search_sort'))){
          $sort_field = Request::input('sort');
          $order = '';
          switch(Request::input('order')){
            case 'asc': 
              $order = 'asc'; 
              break;
            case 'desc':
              $order = 'desc'; 
              break;
            default:
              $order = 'asc';
          }
          $query['sort'] = [$sort_field => ['order' => $order]];
        }

        $q = ['match_all' => []];

        if (Request::has('q')) {
            $field_groups = Config::get('app.elastic_search_field_groups');
            
            if(Request::has('fields') && array_key_exists(Request::get('fields'), $field_groups)){
                foreach ($field_groups[Request::get('fields')] as $field){
                    $q = ['match' => [$field => Request::get('q')]];
                    $query['query']['bool']['should'][] = $q;
                }
            }else {
                $q = ['query_string' => ['query' => Request::get('q')]];
                $query['query']['bool']['must'][] = $q;
            }
        } else {
            $query['query']['bool']['must'][] = ['query_string' => ['query' => '*']];
        }

        foreach ($query['aggregations'] as $key => $aggregation) {
            if (Request::has($key)) {
                $values = Utils::getArgumentValues($key);
                
                if ($key != 'temporal') $field = $aggregation['terms']['field'];
                else $field = $aggregation['aggs']['temporal']['terms']['field'];

                foreach ($values as $value) {
                    $fieldQuery = [];
                    $fieldQuery[$field] = $value;
                    if ($key != 'temporal'){ 
                      $query['query']['bool']['must'][] = ['match' => $fieldQuery];
                    }
                    else{ 
                      $query['query']['bool']['must'][] = ['nested' => [
                                'path' => 'temporal',
                                'query' => [
                                    'bool'=> [
                                        'must' => ['match' => $fieldQuery]
                                    ]
                                ]
                            ]
                        ];
                    }
                }
            }
        }

        if (Request::has('start') && Request::has('end')) {
            $query['query'] = [
                'filtered' => [
                    'query' => $query['query'],
                    'filter' => [
                        'nested' => [
                            'path' => 'temporal',
                            'query' => Timeline::buildRangeQuery(
                                Request::input('start'),
                                Request::input('end')
                            )
                        ]
                    ]
                ]
            ];
        }        
        
        // TODO: refactor so that ES service takes care of bbox parsing
        if (Request::has('bbox')) {
            $bbox = explode(',', Request::input('bbox'));
            $query['query'] = [
                'filtered' => [
                    'query' => $query['query'],
                    'filter' => [
                        'geo_bounding_box' => [
                            'spatial.location' => [
                                'top_left' => [
                                    'lat' => floatval($bbox[3]),
                                    'lon' => floatval($bbox[0])
                                ],                                
                                'bottom_right' => [
                                    'lat' => floatval($bbox[1]),
                                    'lon' => floatval($bbox[2])
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        return $query;
    }

    /**
     * @param $index
     * @param $type
     * @param $location must have keys and values for lat and lon.
     * @return resources within a range of x km of $location.
     */
    public static function geoDistanceQuery($location) {

        $json = '{
            "query" : {

                "filtered" : {
                    "query" : {
                        "bool" : {
                            "must_not": {
                                "match": {
                                    "spatial.location.lat" : '.$location['lat'].'
                                }
                            },
                            "must_not": {
                                "match": {
                                    "spatial.location.lon" : '.$location['lon'].'
                                }
                            }
                        }
                    },
                    "filter" : {
                      "geo_distance" : {
                          "distance" : "50km",
                          "spatial.location" : {
                              "lat" : '.$location['lat'].',
                              "lon" : '.$location['lon'].'
                          }
                      }
                    }
              }
            },
            "sort": [
                {
                    "_geo_distance": {
                    "location": { 
                        "lat" : '.$location['lat'].',
                        "lon" : '.$location['lon'].'
                    },
                    "order":         "asc",
                    "unit":          "km", 
                    "distance_type": "plane" 
                    }
                }
            ]
        }';

        $params = [
            'index' => Config::get('app.elastic_search_catalog_index'),
            'type' => self::RESOURCE_TYPE,
            'body' => $json
        ];

        $result = ElasticSearch::getClient()->search($params);
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
                "temporal.periodName": "' . str_replace(array("\r", "\n", "\t", "\v"), '', $temporal['periodName']) . '"
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
            'index' => Config::get('app.elastic_search_catalog_index'),
            'type' => self::RESOURCE_TYPE,
            'size' => 7,
            'body' => $json
        ];

        $result = ElasticSearch::getClient()->search($params);
        return $result['hits']['hits'];
    }

    /**
     * @param $resource
     * @return count of parts in a collection
     */
    public static function getPartsCountQuery($resource) {

        $json = '{ "query": { "match" : { "isPartOf": ' . $resource['_id'] . ' } } }';

        $params = [
            'index' => Config::get('app.elastic_search_catalog_index'),
            'type' => self::RESOURCE_TYPE,
            'body' => $json
        ];

        $result = ElasticSearch::getClient()->search($params);
        return $result['hits']['total'];
    }
}