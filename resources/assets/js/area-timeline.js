function AreaTimeline(containerId, queryUri, from, to) {

    var margin = 50,
        width  = 1200,
        height = 650;

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
        var targetWidth = container.width();
        chart.attr("width", targetWidth);
        chart.attr("height", Math.round(targetWidth / aspect));
    }).trigger("resize");

    this.triggerSearch = function() {
        var uri = query.toUri();
        window.location.href = uri;
    };

    this.zoomIn = function() {

        queryHistory.push(query.toUri());

        var fromKey = 20;
        var toKey = 40;
        var extent = brush.extent();
        if (extent[0] != extent[1]) {
            fromKey = Math.floor(extent[0]);
            toKey = Math.ceil(extent[1]);
        }
        var bucketArray = d3.entries(buckets);
        query.params.start = bucketArray[fromKey].key.split(":")[0];
        query.params.end = bucketArray[toKey-1].key.split(":")[1];
        updateTimeline();
        d3.selectAll("#" + containerId + " .brush").call(brush.clear());

        $(".timeline .btn-zoom-out").removeClass("disabled");
    }

    this.zoomOut = function() {

        if (queryHistory.length > 0) {
            query = Query.fromUri(queryHistory.pop());
            updateTimeline();
            if (queryHistory.length == 0) {
                $(".timeline .btn-zoom-out").addClass("disabled");
            }
        }

        d3.selectAll("#" + containerId + " .brush").call(brush.clear());
    }

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
            .attr("class", "area");

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
        data=[];
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
        showLoading();
        $.getJSON(query.toUri(), function(data) {
            buckets = data.aggregations.range_buckets.range_agg.buckets;
            redraw();
            hideLoading();
            updateResourceCount(data.total);
        });
    };

    var updateResourceCount = function(count) {
        var formatted = count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $(".timeline .controls .resource-count .count").text(formatted);
    };

    var showLoading = function() {
        $(".timeline .controls .resource-count").hide();
        $(".timeline .controls .loading").show();
    }

    var hideLoading = function() {
        $(".timeline .controls .resource-count").show();
        $(".timeline .controls .loading").hide();
    };

    var query = Query.fromUri(queryUri);
    query.params.start = from;
    query.params.end = to;

    var buckets, x, y, area, xAxis, brush;
    var queryHistory = [];

    initialize();
    updateTimeline();

}