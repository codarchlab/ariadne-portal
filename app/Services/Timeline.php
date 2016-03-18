<?php

namespace App\Services;

use Log;

class Timeline
{

    public static function prepareRangeBucketsAggregation($range) {

        $nrRanges = sizeof($range)-1;
        $nrBuckets=50/$nrRanges;


        $ranges=array();
        for ($i=0;$i<$nrRanges;$i++) {
            self::buildRangePartial($ranges,$range[$i],$range[$i+1],$nrBuckets);
        }



        return [
            'nested' => [
                'path' => 'temporal'
            ],
            'aggs' => [
                'range_agg' => [
                    'filters' => [
                        'filters' => $ranges
                    ]
                ]
            ]
        ];
    }

    private static function buildRangePartial(&$ranges,$startYear,$endYear,$nrBuckets) {
        $diff = $endYear - $startYear;
        $delta = $diff/$nrBuckets;
        Log::info(":::".$startYear. " ". $endYear . " ". $nrBuckets. " ".$delta);

        $cStartYear=$startYear;
        for ($i=0;$i<round($nrBuckets);$i++) {
//            Log::info("".$i." range from " . round($cStartYear) . " " . round($cStartYear+$delta));
            self::addRange($ranges,intval(round($cStartYear)),intval("".round($cStartYear+$delta)));
            $cStartYear=$cStartYear+$delta;
        }


    }

//  return array_reverse($ranges);

    /**
     * Generates a meaningful key for the range and places
     * a newly generated elasticsearch range agg item to ranges[key]
     *
     * @param $ranges array range aggregation to push items to.
     * @param $rangeStartYear string
     * @param $rangeEndYear string
     */
    private static function addRange(&$ranges,$rangeStartYear,$rangeEndYear) {
        $key=$rangeStartYear.":".$rangeEndYear;
        $ranges[$key]=self::buildRangeQuery(
            "".$rangeStartYear,
            "".$rangeEndYear);
        Log::info(":::::".$key);
//        print_r($ranges[$key]);
    }

    /**
     * ElasticSearch aggregation partial.
     *
     * @param $rangeStartYear
     * @param $rangeEndYear
     * @return array
     */
    public static function buildRangeQuery($rangeStartYear, $rangeEndYear) {
        return
            [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'temporal.until' => [
                                    'gte' => $rangeStartYear
                                ]
                            ]
                        ],
                        [
                            'range' => [
                                'temporal.from' => [
                                    'lte' => $rangeEndYear
                                ]
                            ]
                        ]
                    ]
                ]
            ];
    }

}