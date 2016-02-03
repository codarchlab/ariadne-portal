/**
 * Class for viewing search results on a map.
 *
 * Displays a heatmap for large search results based
 * on the elasticsearch geogrid aggregation.
 *
 * Smaller results are displayed as markers.
 */
function GridMap(container, queryUri) {

	var self = this;

	this.drawHeatmap = function(grid) {

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

	this.drawMarkers = function(resources) {
		var markerIcon = L.icon({
			iconUrl: '/img/leaflet/custom/marker-icon-blue.png',
			iconSize: [25, 41],
			iconAnchor: [12, 40],
			shadowUrl: '/img/leaflet/default/marker-shadow.png',
			shadowSize: [41, 41],
			shadowAnchor: [12, 40]
		});

		for (var i = 0; i < resources.length; i++) {
			for (var j = 0; j < resources[i]['_source']['spatial'].length; j++) {
				var spatial = resources[i]['_source']['spatial'][j];
				if ('location' in spatial) {
					var marker = L.marker(spatial.location, { riseOnHover: true, icon: markerIcon });
					var label = spatial.placeName ? spatial.placeName
						: spatial.location.lat + ", " + spatial.location.lon;
					marker.bindLabel(label, { className: "marker-label" });
					marker.on('click', function(e) {
						var q = "spatial.location.lon:\"" + spatial.location.lon
							+ "\" AND spatial.location.lat:\"" + spatial.location.lat + "\"";
						window.location.href = new Query(q).toUri();
                	});
					marker.addTo(map);
					markers.push(marker);
				}
			};

		};

	};

	this.resetLayers = function() {
		if (heatmap) {
			map.removeLayer(heatmap);
		}
		for (var i = 0; i < markers.length; i++) {
			map.removeLayer(markers[i]);
		};
	};

	this.updateResourceCount = function(count) {
		var formatted = count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		$(".map-controls .resource-count .count").text(formatted);
	};

	this.showLoading = function() {
		$(".map-controls .resource-count").hide();
		$(".map-controls .loading").show();
	}

	this.hideLoading = function() {
		$(".map-controls .resource-count").show();
		$(".map-controls .loading").hide();
	};

	this.refreshMap = function() {

		var uri = generateSearchUri();
		requestInProgress = uri;
		self.showLoading();
		$.getJSON(uri, function(data) {
			if(requestInProgress == uri) { // only display last request sent
				self.resetLayers();
				self.updateResourceCount(data.total);
				if (data.total > 100) {
					self.drawHeatmap(data.aggregations.geogrid.buckets);
				} else {
					self.drawMarkers(data.data);
				}
				self.hideLoading();
			}
		});

	};

	this.triggerSearch = function() {
		var uri = generateSearchUri();
		window.location.href = uri;
	};

	function generateSearchUri() {
		query.params['ghp'] = getGhprecFromZoom(map.getZoom());
		query.params['bbox'] = map.getBounds().toBBoxString();
		return query.toUri();
	}

	function getGhprecFromZoom(zl) {
        var ghprecForZoomLevel =
            [3,3,4,4,5,5,6,6,6,7,7,8,8,9,9,9,10,10,10];
        if (zl>18) zl=18;
        return ghprecForZoomLevel[zl];
    }

	function heatMapColorForValue(value) {
		var h = Math.round((1.0 - value) * 240);
		return "hsl(" + h + ", 100%, 60%)";
	}

	function generateGradient(s) {
		var gradient = {};
		for (var i = 1; i <= 10; i++) {
			gradient[s * i / 10] = heatMapColorForValue(i / 10);
		}
		return gradient;
	}

	var map = L.map(container, { zoomControl: false });
	map.addControl( L.control.zoom({position: 'bottomright'}) );

	var query = Query.fromUri(queryUri);
	if (query.params['bbox']) {
		var bounds = query.params.bbox.split(",");
		map.fitBounds([[bounds[1], bounds[0]], [bounds[3], bounds[2]]]);
	} else {
		map.setView([40, 17], 3);
	}

	var heatmap;
	var markers = [];

	var requestInProgress;

	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);
	L.Icon.Default.imagePath = '/img/leaflet/default';

	map.on('moveend', this.refreshMap);

}
