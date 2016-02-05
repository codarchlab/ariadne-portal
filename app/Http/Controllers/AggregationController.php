<?php

namespace App\Http\Controllers;

use DebugBar;
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
    
    $aggregations = Config::get('app.elastic_search_aggregations');
    if(key_exists($aggregationId, $aggregations)){
      $query['aggregations'] = [$aggregationId => $aggregations[$aggregationId]];
      $query['aggregations'][$aggregationId]['terms']['size'] = 100;
    }
    
    $hits = Resource::search($query, 'resource');
    
    if (Request::wantsJson()) {
      return response()->json($hits);
    } else {
      print view('resource.search_facet')
          ->with('key', $aggregationId)
          ->with('buckets', $hits['aggregations'][$aggregationId]['buckets'])
          ->with('translateAggregations', Config::get('app.translate_aggregations'))
          ->with('hits', $hits);
      exit(0);
    }
  }

}