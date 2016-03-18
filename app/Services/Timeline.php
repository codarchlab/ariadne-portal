<?php

namespace App\Services;

class Timeline
{

    /**
     * Creates an ElasticSearch aggregation query object with pre-calculated
     * date ranges of non-equal length. The ranges are calculated on
     * the basis of an algorithm which creates buckets spanning
     * each time more years in an exponential manner, the more
     * far away they are, looking backwards in time, from the next year
     * of the current date.
     *
     * @param $startYear int|string denoting one margin of the data range to divide up into buckets.
     * @param $endYear int|string denoting one margin of the date range to divide up into bucktes.
     *   Can be before or after $startYear.
     * @param $nrBuckets int
     * @return array with a custom range_buckets aggregation object ready for querying
     *   elasticsearch. It contains $nrBuckets of ranges which span each at least one year.
     *   If the difference of $startYear and $endYear is to low for that, one of them gets
     *   adjusted. If at least one of the dates has a year which is in the future, the whole range
     *   gets shifted so that one of the dates will be the current year. Their difference will remain
     *   the same though.
     */
    public static function prepareRangeBucketsAggregation($startYear, $endYear, $nrBuckets) {

        self::swapIfNecessary($startYear,$endYear);
        self::shiftRangeIfNecessary($startYear,$endYear);
        self::extendRangeIfNecessary($startYear,$endYear,$nrBuckets);

        return [
            'nested' => [
                'path' => 'temporal'
            ],
            'aggs' => [
                'range_agg' => [
                    'filters' => [
                        'filters' =>
                            self::calculateRanges($startYear,$endYear,$nrBuckets)
                    ]
                ]
            ]
        ];

    }

    /**
     * @param $startYear string
     * @param $endYear string must be greater or equal $endYear
     */
    private static function shiftRangeIfNecessary(&$startYear,&$endYear) {
        if ($endYear>date("Y")) {
            $shiftWidth=$endYear-date("Y");
            $endYear=$endYear-$shiftWidth;
            $startYear=$startYear-$shiftWidth;
        }
    }

    /**
     * @param $startYear string
     * @param $endYear string
     * @param $nrBuckets int
     */
    private static function extendRangeIfNecessary(&$startYear,$endYear,$nrBuckets) {
        if (($endYear-$startYear)<$nrBuckets) {
            $startYear=$endYear-$nrBuckets;
        }
    }

    /**
     * @param $startYear string
     * @param $endYear string
     */
    private static function swapIfNecessary(&$startYear, &$endYear) {
        if ($endYear<$startYear) {
            $temp=$startYear;
            $startYear=$endYear;
            $endYear=$temp;
        }
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
     * @return array with range agg items.
     */
    private static function calculateRanges($startYear,$endYear,$nrBuckets) {

        $xStartingPoint= self::getXVal($endYear);
        $xDelta=(self::getXVal($startYear)-$xStartingPoint)/$nrBuckets;

        $ranges=array();
        for ($i=0;$i<$nrBuckets;$i++) {
            self::addRange($ranges,
                self::getYear($xStartingPoint+$i*$xDelta+$xDelta), // mirrored, right margin becomes start year
                self::getYear($xStartingPoint+$i*$xDelta)          // mirrored, left margin becomes end year
            );
        }
        return array_reverse($ranges);
    }

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
            $rangeStartYear,
            $rangeEndYear);
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

    private static function getXVal($year) {
        return log(self::referenceYear()-$year,self::LOG_BASE);
    }

    /**
     * @param $xVal
     * @return string year
     */
    private static function getYear($xVal) {
        return "".round(self::referenceYear()-pow(self::LOG_BASE,$xVal));
    }

    const LOG_BASE = 10;

    private static function referenceYear() {
        return date("Y")+1;
    }

}