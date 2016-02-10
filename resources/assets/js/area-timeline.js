function AreaTimeline(containerId, queryUri, from, to) {

    var margin = 50,
        width  = 1200,
        height = 700;

    var svg = d3.select("#"+containerId).append("svg")
        .attr("width", width)
        .attr("height", height)
        .attr("viewBox", "0 0 " + width + " " + height)
        .attr("preserveAspectRatio", "xMinYMid")
        .append("g");

    var chart = $("#"+containerId + " svg"),
        aspect = chart.width() / chart.height(),
        container = chart.parent();
    $(window).on("resize", function() {
        console.log(container.width());
        var targetWidth = container.width();
        chart.attr("width", targetWidth);
        chart.attr("height", Math.round(targetWidth / aspect));
    }).trigger("resize");

    var initialize = function() {

        x = d3.scale.linear()
            .range([0 + margin, width - margin]);

        y = d3.scale.linear()
            .range([height - margin, 0]);

        area = d3.svg.area()
            .interpolate("basis")
            .x(function(d) { return x(d.x); })
            .y0(function(d) { return y(d.y0); })
            .y1(function(d) { return y(d.y0 + d.y); });

        xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom")
            .tickFormat(getLabelForBucket);

        svg.append("path")
            .attr("class", "area")
            .style("fill", "#aad");

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + (height - margin) + ")")
            .call(xAxis);

        brush = d3.svg.brush()
            .x(x)
            .on("brush", brushed);

        var gBrush = svg.append("g")
            .attr("class", "brush")
            .call(brush);

        gBrush.selectAll("rect")
            .attr("height", height);

    }

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
                x: i,
                y: buckets[key].doc_count,
                y0: 0
            });
            i++;
        }
        return [data];
    };

    var brushed = function() {

        console.log(brush.extent());
        // TODO: calc selected objects, implement buttons for zooming and searching
    }

    var redraw = function() {

        x.domain([0, d3.entries(buckets).length]);
        y.domain([0, d3.max(d3.entries(buckets), function(entry) {
            return entry.value.doc_count;
        })]);
        
        var data = convertESBuckets(buckets);
        svg.select("path.area")
            .data(data)
            .attr("d", area);
        svg.select("g.x.axis").call(xAxis);
    }

    var getLabelForBucket = function(i) {
        if (d3.entries(buckets)[i])
            return d3.entries(buckets)[i].key.split(":")[0];
        else if (d3.entries(buckets)[i-1])
            return d3.entries(buckets)[i-1].key.split(":")[1];
        else
            return null;
    }

    var updateTimeline = function() {
        $.getJSON(query.toUri(), function(data) {
            buckets = data.aggregations.range_buckets.range_agg.buckets;
            redraw();
        });
    };

    var query = Query.fromUri(queryUri);
    query.params.start = from;
    query.params.end = to;

    var buckets, x, y, area, xAxis, brush;

    initialize();
    updateTimeline();

}