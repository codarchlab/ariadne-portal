function GridMap(container) {

	var self = this;

	this.drawHeatmap = function(grid) {

		if (heatmap) {
			map.removeLayer(heatmap);
		}

		var max = grid[0]['doc_count'];
		var heatPoints = [];

		grid.forEach(function(bucket) {
			var point = Geohash.decode(bucket['key']);
			heatPoints.push([point.lat, point.lon, bucket['doc_count']]);
		});

		heatmap = L.heatLayer(heatPoints, { 
			radius: 25,
			max: max,
			gradient: generateGradient(0.5),
			minOpacity: 0.1
		}).addTo(map);

	};

	this.refreshGrid = function() {

		var uri = generateSearchUri();
		requestInProgress = uri;
		$.getJSON(uri, function(data) {
			if(requestInProgress == uri) { // only display last request sent
				self.drawHeatmap(data['aggregations']['geogrid']['buckets']);
			}
		});

	}

	this.triggerSearch = function() {
		var uri = generateSearchUri();
		window.location.href = uri;
	}

	function generateSearchUri() {
		var ghPrecision = getGhprecFromZoom(map.getZoom());
		var bBox = map.getBounds().toBBoxString();
		return "/search?ghp="+ghPrecision+"&bbox="+bBox;
	}

	function performSearch(bounds) {
		var bBox = bounds.toBBoxString();
		var uri = "/search?bbox="+bBox;
		window.location.href = uri;
	}

	function getGhprecFromZoom(zl) {
        var ghprecForZoomLevel =
            [3,3,4,4,4,4,5,5,5,6,6,7,7,8,8,8,9,9,9];
        if (zl>18) zl=18;
        return ghprecForZoomLevel[zl];
    }

	function heatMapColorforValue(value) {
		var h = Math.round((1.0 - value) * 240);
		return "hsl(" + h + ", 100%, 60%)";
	}

	function generateGradient(s) {
		var gradient = {};
		for (var i = 1; i <= 10; i++) {
			gradient[s * i / 10] = heatMapColorforValue(i / 10);
		}
		return gradient;
	}

	var map = L.map(container, { zoomControl: false }).setView([40, 17], 3);
	map.addControl( L.control.zoom({position: 'bottomright'}) )	

	var heatmap;

	var requestInProgress;

	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	map.on('zoomend', this.refreshGrid);
	map.on('moveend', this.refreshGrid);

}
