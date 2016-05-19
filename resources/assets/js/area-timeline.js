function AreaTimeline(containerPath, queryUri, fullscreen, buckets) {

    var INITIAL_TICKS = [-1000000,-100000,-10000,-1000,0,1000,1250,1500,1750,new Date().getFullYear()];

    var ZOOM_FACTOR = 4;

    var margin = 50,
        width  = 1200,
        height = 650;

    this.triggerSearch = function() {
        var extent = brush.extent();
        if (extent[0] != extent[1]) {
            query.params.range = [Math.floor(extent[0]), Math.ceil(extent[1])].join();
        }
        var uri = query.toUri();
        window.location.href = uri;
    };

    this.removeRange = function() {
        delete query.params.range;
        window.location.href = query.toUri();
    };

    this.zoomIn = function() {

        $(".timeline .brush-controls").hide();

        var extent = brush.extent();
        if (extent[0] != extent[1]) {
            query.params.range = [Math.floor(extent[0]), Math.ceil(extent[1])].join();
        } else {
            var start = domain[0];
            var end = domain[domain.length-1];
            var center = x.invert(width / 2);
            var zoomWidth = width / ZOOM_FACTOR / 2;
            query.params.range = [Math.round(x.invert(width / 2 - zoomWidth)),
                Math.round(x.invert(width / 2 + zoomWidth))].join();
        }
        updateLocation();
        updateTimeline();
        d3.selectAll(containerPath + " .brush").call(brush.clear());

        $(".timeline .btn-zoom-out").removeClass("disabled");
        $(".timeline .brush-controls").hide();
    };

    this.zoomOut = function() {

        var start = domain[0];
        var end = domain[domain.length-1];

        // go to initial zoom for larger areas
        if (end - start > 5000) {
            query.params.range = INITIAL_TICKS;
        } else {
            var center = x.invert(width / 2);
            var zoomWidth = width * ZOOM_FACTOR / 2;
            var newStart = Math.round(x.invert(width / 2 - zoomWidth));
            var newEnd = Math.round(x.invert(width / 2 + zoomWidth));
            query.params.range = [ (newStart > INITIAL_TICKS[0]) ? newStart : INITIAL_TICKS[0],
                (newEnd < INITIAL_TICKS[INITIAL_TICKS.length-1]) ? newEnd : INITIAL_TICKS[INITIAL_TICKS.length-1]  ].join();
        }

        updateLocation();
        updateTimeline();

        d3.selectAll(containerPath + " .brush").call(brush.clear());
        $(".timeline .brush-controls").hide();
    };

    var initialize = function() {

        svg.append("linearGradient")
            .attr("id", "timeline-gradient")
            .attr("gradientUnits", "userSpaceOnUse")
            .attr("x1", "0%").attr("y1", "0%")
            .attr("x2", "0%").attr("y2", "100%")
            .selectAll("stop")
                .data([
                    {offset: "0%", color: "#BB3921"},
                    {offset: "50%", color: "#D5A03A"},
                    {offset: "100%", color: "#75A99D"}
                ])
            .enter().append("stop")
                .attr("offset", function(d) { return d.offset; })
                .attr("stop-color", function(d) { return d.color; });

        x = d3.scale.linear()
            .domain(INITIAL_TICKS)
            .range(calculateRange(INITIAL_TICKS));

        y = d3.scale.linear()
            .domain([0,550000])
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
            .tickFormat(function(d) {
                if (Math.abs(d).toString().length > 4) return commaFormat(d);
                else return yearFormat(d);
            });

        yAxis = d3.svg.axis()
            .scale(y)
            .tickSize(width - margin * 3)
            .orient("left");

        svg.append("path")
            .attr("class", "area")
            .attr("fill", "url(#timeline-gradient)");

        svg.append("g")
            .attr("class", "x axis")
            .attr("visibility","hidden")
            .attr("transform", "translate(0," + (height - margin) + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "y axis")
            .attr("visibility","hidden")
            .attr("transform", "translate(" + (width - margin) + ",0)")
            .call(yAxis);
        // hide tick at zero
        d3.select(svg.selectAll(".y.axis .tick")[0][0]).attr("visibility","hidden");

    };

    var updateTimeline = function() {
        showLoading();
        $.getJSON(query.toUri(), function(data) {
            var buckets = data.aggregations.range_buckets.range_agg.buckets;
            redraw(convertESBuckets(buckets));
            hideLoading();
        });
    };

    var onResize = function() {
        var targetWidth = container.width();
        var targetHeight;
        if (fullscreen) targetHeight = container.height();
        else targetHeight = Math.round(targetWidth / aspect);
        chart.attr("width", targetWidth);
        chart.attr("height", targetHeight);
        if (brush) {
            $(".timeline .brush-controls").css("left", Math.round(x(brush.extent()[1]) / width * targetWidth));
        }
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
            data.push({
                x: start,
                y: buckets[key].doc_count,
                y0: 0,
                start: start,
                end: end
            });
            i++;
        }
        // add bucket for last end year
        data.push({
            x: end,
            y: buckets[key].doc_count,
            y0: 0,
            start: end,
            end: end
        });  
        return data;
    };

    var brushed = function() {

        var extent = brush.extent();

        if (extent[0] != extent[1]) {
            var controls = $(".timeline .brush-controls");
            controls.css("left", Math.round(x(extent[1]) / width * container.width() ) + 5 );
            controls.show();
            controls.find(".timespan")
                .html(Math.floor(extent[0]).toString()
                    + ', '
                    + Math.ceil(extent[1]).toString());
        } else {
            $(".timeline .brush-controls").hide();
        }
    }

    var redraw = function(data) {

        var minYear = data[0].start;
        var maxYear = data[data.length-1].end;

        domain = calculateDomain(minYear, maxYear);
        x.domain(domain);
        x.range(calculateRange(domain));

        var yMax = d3.max(data, function(entry) {
            return entry.y;
        });
        y.domain([0, yMax]);

        if (domain.length > 5) {
            xAxis.tickValues(domain);
        } else {
            xAxis.tickValues(null);
        }
        
        svg.select("path.area")
            .data([data])
            .transition()
            .delay(500)
            .duration(1000)
            .attr("d", area);

        svg.select("g.x.axis")
            .attr("visibility","visible")
            .transition()
            .duration(1000)
            .call(xAxis);
        svg.select("g.y.axis")
            .attr("visibility","visible")
            .transition()
            .duration(1000)
            .call(yAxis);
        // hide uppermost tick
        var ticks = svg.selectAll(".y.axis .tick");
        d3.select(ticks[0][ticks[0].length-1]).attr("visibility","hidden");

        createBrush();

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

    var calculateDomain = function(start, end) {
        if (start <= INITIAL_TICKS[0] && end >= INITIAL_TICKS[INITIAL_TICKS.length-1])
            return INITIAL_TICKS;
        else
            return [start, end];
    };

    var calculateRange = function(domain) {
        var range = [];
        var actualWidth = width - 2 * margin;
        var tickWidth = actualWidth / (domain.length-1);
        for (var i = 0; i < domain.length; i++) {
            range.push(i * tickWidth + margin);
        }
        return range;
    };

    var showLoading = function() {
        $(".timeline .controls .resource-count").hide();
        $(".timeline .controls .loading").show();
    };

    var hideLoading = function() {
        $(".timeline .controls .resource-count").show();
        $(".timeline .controls .loading").hide();
    };

    var updateLocation = function() {
        if (window.history) {
            var range = query.params.range;
            var location = updateQueryStringParameter(window.location.href, 'range', range);
            window.history.pushState('when', $('title').text, location);
        }
    };

    var updateQueryStringParameter = function(uri, key, value) {
      var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
      if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
      }
      else {
        return uri + separator + key + "=" + value;
      }
    };

    var svg = d3.select(containerPath).append("svg")
        .attr("width", width)
        .attr("height", height)
        .attr("viewBox", "0 0 " + width + " " + height)
        .attr("preserveAspectRatio", "xMidYMin")
        .append("g");

    var chart = $(containerPath + " svg"),
        aspect = chart.width() / chart.height(),
        container = chart.parent();

    $(window).on("resize", onResize).trigger("resize");

    var query = Query.fromUri(queryUri);
    if (query.params['range']) {
        $(".timeline .controls .btn-remove").show();
    } else {
        query.params.range = INITIAL_TICKS.join();
        $(".timeline .controls .btn-remove").hide();
    }

    var x, y, area, xAxis, brush, domain;

    initialize();
    if (buckets) {
        redraw(convertESBuckets(buckets));
        hideLoading();
    } else {
        updateTimeline();
    }

}