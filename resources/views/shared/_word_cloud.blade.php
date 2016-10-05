<?php
// $cloud_data -> see Http/Controllers/BrowseController
$aggs = $cloud_data->aggregations();
//Debugbar::debug($aggs);

// Known buckets...
// See query in Services/Utils
$aggsBuckets = array( $aggs['derivedSubject'] );

foreach ($aggsBuckets as $aggKey => $aggVal) {
  //Debugbar::debug( $aggVal['buckets'] );
  foreach ($aggVal['buckets'] as $bucket) {
    $filteredAggs[] = array($aggKey, $bucket['key'], $bucket['doc_count']);
  }
}

/*
 * .css and .js is automatically inluded to webroot when biult with gulp.
 * For wordcloud they are:
 *  1. /resources/assets/js/jqcloud.js
 *  2. /resources/assets/sass/word_cloud.css
 */

?>
<script>
  var filteredAggs = <?php echo json_encode($filteredAggs); ?>;
  var wordCloudAggs = [];
  
  for (var i = 0; i < filteredAggs.length; i++) {
    var currAgg = {text: filteredAggs[i][1], weight: filteredAggs[i][2], link: '/search?q='+filteredAggs[i][1]};
    wordCloudAggs.push(currAgg);
  }

  $("#wordCloud").jQCloud(wordCloudAggs, {
    shape: 'elliptic',
    autoResize: true,
  });
</script>