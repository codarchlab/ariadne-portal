function AreaTimeline(containerId, queryUri, fullscreen) {

    var INITIAL_TICKS = [-1000000,-100000,-10000,-1000,0,1000,1500,new Date().getFullYear()];

    var ZOOM_FACTOR = 4;

    var margin = 50,
        width  = 1200,
        height = 650;

    var svg = d3.select("#"+containerId).append("svg")
        .attr("width", width)
        .attr("height", height)
        .attr("viewBox", "0 0 " + width + " " + height)
        .attr("preserveAspectRatio", "xMidYMid")
        .append("g");

    var chart = $("#"+containerId + " svg"),
        aspect = chart.width() / chart.height(),
        container = chart.parent();
    $(window).on("resize", function() {
        var targetWidth = container.width();
        var targetHeight;
        if (fullscreen) targetHeight = container.height();
        else targetHeight = Math.round(targetWidth / aspect);
        chart.attr("width", targetWidth);
        chart.attr("height", targetHeight);
    }).trigger("resize");

    this.triggerSearch = function() {
        var uri = query.toUri();
        window.location.href = uri;
    };

    this.zoomIn = function() {

        var extent = brush.extent();
        if (extent[0] != extent[1]) {
            query.params.start = Math.floor(extent[0]);
            query.params.end = Math.ceil(extent[1]);
        } else {
            var start = domain[0];
            var end = domain[domain.length-1];
            var center = x.invert(width / 2);
            var zoomWidth = width / ZOOM_FACTOR / 2;
            query.params.start = Math.round(x.invert(width / 2 - zoomWidth));
            query.params.end = Math.round(x.invert(width / 2 + zoomWidth));
        }
        updateTimeline();
        d3.selectAll("#" + containerId + " .brush").call(brush.clear());

        $(".timeline .btn-zoom-out").removeClass("disabled");
    };

    this.zoomOut = function() {

        var start = domain[0];
        var end = domain[domain.length-1];

        // go to initial zoom for larger areas
        if (end - start > 5000) {
            query.params.start = INITIAL_TICKS[0];
            query.params.end = INITIAL_TICKS[INITIAL_TICKS.length-1];
        } else {
            var center = x.invert(width / 2);
            var zoomWidth = width * ZOOM_FACTOR / 2;
            var newStart = Math.round(x.invert(width / 2 - zoomWidth));
            var newEnd = Math.round(x.invert(width / 2 + zoomWidth));
            query.params.start = (newStart > INITIAL_TICKS[0]) ? newStart : INITIAL_TICKS[0];
            query.params.end = (newEnd < INITIAL_TICKS[INITIAL_TICKS.length-1]) ? newEnd : INITIAL_TICKS[INITIAL_TICKS.length-1];
        }

        updateTimeline();

        d3.selectAll("#" + containerId + " .brush").call(brush.clear());
    };

    var initialize = function() {

        x = d3.scale.linear();

        y = d3.scale.linear()
            .range([height - margin, 0]);

        area = d3.svg.area()
            .interpolate("basis")
            .x(function(d) { return x(d.x); })
            .y0(function(d) { return y(d.y0); })
            .y1(function(d) { return y(d.y0 + d.y); });

        var commaFormat = d3.format(',d');
        var yearFormat = d3.format('d');

        xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom")
            .tickValues(INITIAL_TICKS)
            .tickFormat(function(d) {
                if (Math.abs(d).toString().length > 4) return commaFormat(d);
                else return yearFormat(d);
            });

        svg.append("path")
            .attr("class", "area");

        svg.append("path")
            .attr("class", "symbols");

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + (height - margin) + ")")
            .call(xAxis);

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
        data=[];
        var i=0;
        for (key in buckets) {
            var keys = key.split(':');
            var start = parseInt(keys[0]);
            var end = parseInt(keys[1]);
            var year = (start + end) / 2;
            data.push({
                x: year,
                y: buckets[key].doc_count,
                y0: 0,
                start: start,
                end: end
            });
            i++;
        }
        return data;
    };

    var brushed = function() {

        // TODO: calc selected objects, implement buttons for zooming and searching
    }

    var redraw = function(buckets) {

        var data = convertESBuckets(buckets);

        var minYear = data[0].start;
        var maxYear = data[data.length-1].end;

        domain = getDomainForSpan(minYear, maxYear);
        x.domain(domain);
        var range = getRangeForDomain(domain);
        x.range(range);

        y.domain([0, d3.max(d3.entries(buckets), function(entry) {
            return entry.value.doc_count;
        })]);

        xAxis.tickValues(generateTickValues(domain));
        
        svg.select("path.area")
            .data([data])
            .attr("d", area);

        svg.select("g.x.axis").call(xAxis);

        svg.selectAll("path.symbol").remove();

        svg.selectAll("path.symbols")
            .data(data)        
            .enter().append("path")
                .attr("class", "symbol")
                .attr("transform", function(d) { return "translate(" + x(d.x) + "," + y(d.y) + ")"; })
                .attr("d", d3.svg.symbol());

        createBrush();

    };

    var generateTickValues = function(domain) {
        if (domain.length > 5) return domain;
        var start = domain[0];
        var end = domain[domain.length-1];
        // calculate exact interval for 25 ticks
        var intervalExact = Math.abs(Math.round((start - end) / 25));
        console.log("intervalExact", intervalExact);
        // round interval to decimal
        var interval = Math.pow(10,intervalExact.toString().length);
        console.log("interval", interval);
        var ticks = [];
        // add ticks for positive values
        for (var i = 1; i * interval < end; i++)
            if (i * interval > start) ticks.push(i * interval);
        // add ticks for negative values
        for (var i = 0; i * interval > start; i--)
            if (i * interval < end) ticks.push(i * interval);
        return ticks;
    };

    var createBrush = function() {
        brush = d3.svg.brush()
            .x(x)
            .on("brush", brushed);
        var gBrush = svg.append("g")
            .attr("class", "brush")
            .call(brush);
        gBrush.selectAll("rect")
            .attr("height", height);
    };

    var getDomainForSpan = function(start, end) {
        if (start == INITIAL_TICKS[0] && end == INITIAL_TICKS[INITIAL_TICKS.length-1])
            return INITIAL_TICKS;
        else
            return [start, end];
    };

    var getRangeForDomain = function(domain) {
        var range = [];
        var actualWidth = width - 2 * margin;
        var tickWidth = actualWidth / (domain.length-1);
        for (var i = 0; i < domain.length; i++) {
            range.push(i * tickWidth + margin);
        }
        return range;
    };

    var updateTimeline = function() {
        showLoading();
        $.getJSON(query.toUri(), function(data) {
            var buckets = data.aggregations.range_buckets.range_agg.buckets;
            redraw(buckets);
            hideLoading();
        });
    };

    var showLoading = function() {
        $(".timeline .controls .resource-count").hide();
        $(".timeline .controls .loading").show();
    };

    var hideLoading = function() {
        $(".timeline .controls .resource-count").show();
        $(".timeline .controls .loading").hide();
    };

    var query = Query.fromUri(queryUri);
    if (!query.params['start']) query.params.start = -1000000; 
    if (!query.params['end']) query.params.end = new Date().getFullYear();

    var x, y, area, xAxis, brush, domain;

    initialize();
    updateTimeline();

}