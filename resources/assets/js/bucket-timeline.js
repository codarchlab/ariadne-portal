/**
 * A chart showing a number of buckets corresponding to portions
 * of a logarithmic timeline. Each bucket contains a doc_count
 * which measures the number of resources which have date ranges
 * reaching in or ranging over the correpsonding timespan of the bucket.
 *
 * @param container string the id of the dom element used
 *   to render the chart into.
 */
function BucketTimeline(container) {

    var bucketElWidth = 10; // in px
    var bucketElHeight = 400; // in px

    var addBoxElements = function(bucketElements) {
        bucketElements
            .append('button').attr('onclick', function(d){
                return "bucketTimeline.renderIntoDOM("+ d.from+","+ d.to+");";
            })
            .style("width", function(d) { return bucketElWidth+"px"; })
            .style("height", function(d) { return bucketElHeight+"px" })
            .style("background-color", function(d){ var color='#F8F8F8 ';
                if ((d.index%2)==0) color='#F0F0F0'; return color; })
            .style("position", "absolute")
            .style("left", function(d) { return d.index*bucketElWidth+"px"; });
    };


    var addDateElements = function(bucketElements) {
        bucketElements
            .append('p').text(function(d) { return d.range })
            .style("position","absolute")
            .style("top","10px")
            .style("font-size","8px")
            .style("left",function(d) {return d.index*bucketElWidth+5+"px"});
    };

    var addDocCountElements = function(bucketElements) {
        bucketElements
            .append('a').attr('href', function(d){
                return '/search?start='+ d.from+'&end='+d.to;
            })
            .append('p').text( function(d) { return d.text } )
            .style("position","absolute")
            .style("top","100px")
            .style("left",function(d) {return d.index*bucketElWidth+30+"px"})
            .style("font-size","12px")
            .style("background-color","black")
            .style("background-color","white");
    };

    /**
     * Takes date_buckets and
     * converts it into a dataset
     * digestable by d3.
     *
     * @param buckets date_buckets. An ElasticSearch
     *   aggregation as built and provided by the
     *   ResourceController.
     * @returns {Array} the dataset for d3.
     */
    var convertESBuckets = function(buckets) {
        var data=[];
        var i=0;
        for (key in buckets) {
            data.push({
                index: i,
                range: key,
                from: key.split(":")[0],
                to: key.split(":")[1],
                text: buckets[key].doc_count});
            i++;
        }
        return data;
    };

    /**
     * Creates the basic div elements corresponding to the buckets retrieved
     * from the elasticsearch agg. These elements can then get
     * enriched by the add* functions.
     *
     * @param esBuckets
     * @param container string
     * @returns {*|void}
     */
    var createBucketElements = function(container,esBuckets) {
        var bucketElements= d3.select("#"+container).selectAll("div")
            .data(convertESBuckets(esBuckets))
            .enter().append("div");
        return bucketElements;
    };

    var buildQuery = function(startYear,endYear) {
        var q = new Query();
        if ((startYear!=undefined)&&(endYear!=undefined)) {
            q.params.start = startYear;
            q.params.end = endYear;
        }
        return q;
    };

    /**
     * Removes the old chart and paints a new one.
     * 
     * @param container
     * @param data
     */
    var redraw = function(container,data) {
        d3.select("#"+container).selectAll("div").remove();

        var bucketElements =
            createBucketElements(container, data.aggregations.range_buckets.buckets);

        addBoxElements(bucketElements);
        addDateElements(bucketElements);
        addDocCountElements(bucketElements);
    };

    /**
     * Acquires the data and builds and renders
     * the graph for a given range into the dom.
     *
     * @param startYear
     * @param endYear
     */
    this.renderIntoDOM = function(startYear,endYear) {
        $.getJSON(buildQuery(startYear,endYear).toUri(), function(data) {
            redraw(container,data);
        });
    };
}