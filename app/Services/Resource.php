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


    /**
     * Creates an aggregation partial with pre-calculated date
     * ranges of non-equal length. The ranges are calculated on
     * the basis of an algorithm which creates buckets spanning
     * each time more years in an exponential manner, the more
     * far away they are, looking backwards in time from the next year
     * of the current date.
     *
     * @param $startYear
     * @param $endYear
     * @param $nrBuckets
     * @return array
     */
    public static function prepareDateRangesAggregation($startYear,$endYear,$nrBuckets) {

        return ['date_range' => [
            'field' => 'temporal.from',
            'format' => 'yyyyyy',
            'ranges'  => self::calculateRanges($startYear,$endYear,$nrBuckets)
        ]];
    }

    /**
     * We arrange the years on the y-axis of a graph whose x-axis serves
     * us to map them to something linear. This allows for dividing any
     * given ranges from $startYear to $endYear into a $nrBuckets of equals
     * sub-ranges. Mapping back the start and end points of these ranges
     * gives us the corresponding years again.
     *
     * The mapping function is a plain exponential function. The x-axis value
     * is used as the exponent which results in ever growing year values on the
     * y-axis. Arranging the years in this way accounts for an intuition where
     * the resources we have are distributed more sparsely the more we
     * move backwards in time.
     *
     * To use the exponential function, $startYear and $endYear are mirrored on and
     * arranged relatively to a reference year, which is the next year seen from now.
     * This year acts the null point of the y-axis of the the graph.
     *
     * @param $startYear
     * @param $endYear
     * @param $nrBuckets
     * @return array with range items like
     *   [ 'from' => string, - year with six digits.
     *   'to' => string ]    - year with six digits.
     */
    private static function calculateRanges($startYear,$endYear,$nrBuckets) {

        $margin= self::getXVal($endYear);
        $delta=(self::getXVal($startYear)-$margin)/$nrBuckets;

        $selectedRanges=array();
        for ($i=0;$i<$nrBuckets;$i++) {
            array_push($selectedRanges,
                [
                    'to'=>sprintf('%06d',self::getYear($margin+$i*$delta)),
                    'from'=>sprintf('%06d',self::getYear($margin+$i*$delta+$delta))
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