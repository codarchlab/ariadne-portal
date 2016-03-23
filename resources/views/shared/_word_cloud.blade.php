<?php
$aggs = $cloud_data->aggregations();
foreach ($aggs as $aggKey => $aggVal) {
  //Debugbar::debug($aggVal);
  foreach ($aggVal['buckets'] as $bucket) {
    $filteredAggs[] = array($aggKey, $bucket['key'], $bucket['doc_count']);
  }
}
//Debugbar::debug($filteredAggs);

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