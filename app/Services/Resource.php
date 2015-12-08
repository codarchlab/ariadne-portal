<?php
/**
 * Service for accessing resources in the catalog
 *
 * Wraps access to the elasticsearch index representing the ariadne catalog.
 */

namespace app\Services;
use App\Services\ElasticSearch;
use Config;


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




    public static function prepareDateRangesAggregation($startYear,$endYear,$nrBuckets) {

        return ['date_range' => [
            'field' => 'temporal.from',
            'format' => 'yyyyyy',
            'ranges'  => self::calculateRanges($startYear,$endYear,$nrBuckets)
        ]];
    }

    private static function calculateRanges($startYear,$endYear,$nrBuckets) {

        $r= self::getXVal($endYear);
        $d=(self::getXVal($startYear)-$r)/$nrBuckets;

        $selectedRanges=array();
        for ($i=0;$i<$nrBuckets;$i++) {
            array_push($selectedRanges,
                [
                    'to'=>sprintf('%06d',self::getYear($r+$i*$d)),
                    'from'=>sprintf('%06d',self::getYear($r+$i*$d+$d))
                ]
            );
        }
        return $selectedRanges;
    }

    private static function getXVal($year) {
        return log(self::referenceYear()-$year,self::LOG_BASE);
    }

    private static function getYear($xVal) {
        return self::referenceYear()-pow(self::LOG_BASE,$xVal);
    }

    const LOG_BASE = 10;

    private static function referenceYear() {
        return date("Y")+1;
    }

}