/**
 * A chart showing a range of years on a timeline and the number of
 * resources found which have from dates for these years.
 *
 * @param container the id of the dom element used
 *   to show the chart.
 */
function BucketTimeline(container) {

    var bucketElWidth= 100; // in px
    var bucketElHeight=400; // in px

    var addBoxElements = function(bucketElements) {
        bucketElements
            .append('button').attr('onclick', function(d){
                return "bucketTimeline.present("+ d.from+","+ d.to+");";
            })
            .style("width", function(d) { return bucketElWidth+"px"; })
            .style("height", function(d) { return bucketElHeight+"px" })
            .style("background-color", function(d){ var color='#F8F8F8 ';
                if ((d.index%2)==0) color='#F0F0F0'; return color; })
            .style("position", "absolute")
            .style("left", function(d) { return d.index*bucketElWidth+"px"; })
            ;
    };


    var addDateElements = function(bucketElements) {
        bucketElements
            .append('p').text(function(d) { return d.range })
            .style("position","absolute")
            .style("top","10px")
            .style("left",function(d) {return d.index*bucketElWidth+5+"px"});
    };

    var addDocCountElements = function(bucketElements) {
        bucketElements
            .append('a').attr('href', function(d){
                return '/search?start='+ d.from+'&end='+ d.to;
            })
            .append('p').text( function(d) { return d.text } )
            .style("position","absolute")
            .style("top","100px")
            .style("left",function(d) {return d.index*bucketElWidth+30+"px"})
            .style("font-size","30px")
            .style("background-color","black")
            .style("background-color","white");
    };

    /**
     * Takes the elasticsearch data buckets and
     * converts into a dataset digestable by d3.
     *
     * @param buckets elastic search data_range buckets.
     * @returns {Array} the dataset for d3.
     */
    var convertESBuckets = function(buckets) {
        var da=[];

        var i=0;
        for (key in buckets) {
            da.push({
                index: i,
                range: key,
                text: buckets[key].doc_count});
            i++;
        }
        return da;
    };

    /**
     * Creates the basic div elements corresponding to the buckets retrieved
     * from the elasticsearch agg. These elements can then get
     * enriched by the add* functions.
     *
     * @param esBuckets
     * @returns {*|void}
     */
    var createBucketElements = function(esBuckets) {
        var bucketElements= d3.select("#chart").selectAll("div")
            .data(convertESBuckets(esBuckets))
            .enter().append("div");
        return bucketElements;
    };
    
    this.present = function(startYear,endYear) {

        var query="/search?q=*";
        if (startYear!=undefined&&endYear!=undefined)
            query= "/search?start="+startYear+"&end="+endYear;

        $.getJSON(query, function(data) {
            console.log(data)
            d3.select("#chart").selectAll("div").remove();

            var bucketElements =
                createBucketElements(data.aggregations.date_ranges.buckets);
            
            addBoxElements(bucketElements);
            addDateElements(bucketElements);
            addDocCountElements(bucketElements);
        });
    };
}