<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Services\Resource;
use App\Services\Utils;
use Request;
use stdClass;


class AggregationController extends Controller {

  /**
   * Ajax callback for geting replacement html for aggregations filter
   * @param string $aggregationId The aggregation to get html filter for
   * @return rendered html for a fragment filter
   */
  public function getAggregationBucketHtml($aggregationId) {
    $query = Resource::getCurrentQuery();
    $size = Request::input('size', 100);
    
    $aggregations = Config::get('app.elastic_search_aggregations');
    if(key_exists($aggregationId, $aggregations)){
      $query['aggregations'] = [$aggregationId => $aggregations[$aggregationId]];
      if (array_key_exists('nested', $query['aggregations'][$aggregationId])) {
        $query['aggregations'][$aggregationId]['aggs']
          [$aggregationId]['terms']['size'] = $size;
      } else {
        $query['aggregations'][$aggregationId]['terms']['size'] = $size;
      }
    }
    
    $hits = Resource::search($query, 'resource');

    if (array_key_exists('nested', $query['aggregations'][$aggregationId])) {
      $buckets = $hits['aggregations'][$aggregationId][$aggregationId]['buckets'];
    } else {
      $buckets = $hits['aggregations'][$aggregationId]['buckets'];
    }
    
    if (Request::wantsJson()) {
      return response()->json($hits);
    } else {
      print view('resource.search_facet')
          ->with('key', $aggregationId)
          ->with('buckets', $buckets)
          ->with('translateAggregations', Config::get('app.translate_aggregations'))
          ->with('hits', $hits);
      exit(0);
    }
  }

}
