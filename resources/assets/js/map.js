function GridMap(container) {

	var self = this;

	this.drawGrid = function(grid) {

		var max = grid[0]['doc_count'];

		// remove old grid layers when redrawing
		layers.forEach(function(layer) {
			map.removeLayer(layer);
		});

		grid.forEach(function(bucket) {
			var corners = Geohash.bounds(bucket['key']);
			var bounds = L.latLngBounds(corners.sw, corners.ne);
		    var heat = Math.pow(bucket['doc_count'] / max, 1/5); // add curve to accomodate for long-tail distibution
			var rect = L.rectangle(bounds, {color: heatMapColorforValue(heat), weight: 1}).addTo(map);
			rect.on('click', function(e) { performSearch(bounds); });
			layers.push(rect);
			var label = L.marker(bounds.getCenter(), {
				icon: L.divIcon({
					className: 'grid-label-container',
					html: '<div class="grid-label">'+bucket['doc_count'].toLocaleString('en-US')+'</div>'
				}),
				zIndexOffset: 1000
			}).addTo(map);
			label.on('click', function(e) { performSearch(bounds); });
			layers.push(label);
		});

	};

	this.refreshGrid = function() {

		var ghPrecision = getGhprecFromZoom(map.getZoom());
		var bBox = map.getBounds().toBBoxString();

		var uri = "/search?ghp="+ghPrecision+"&bbox="+bBox;
		requestsInProgress++;
		$.getJSON(uri, function(data) {
			requestsInProgress--;
			if(requestsInProgress == 0) // prevent overriding grid if requests are in progress
				self.drawGrid(data['aggregations']['geogrid']['buckets']);
		});

	}

	var map = L.map(container, { zoomControl: false }).setView([40, 17], 3);
	map.addControl( L.control.zoom({position: 'bottomright'}) )
	var layers = [];
	var requestsInProgress = 0;

	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	map.on('zoomend', this.refreshGrid);
	map.on('moveend', this.refreshGrid);

	function performSearch(bounds) {
		var bBox = bounds.toBBoxString();
		var uri = "/search?bbox="+bBox;
		window.location.href = uri;
	}

	function getGhprecFromZoom(zl) {
        var ghprecForZoomLevel =
            [1,1,2,2,2,2,3,3,3,4,4,5,5,6,6,6,7,7,7];
        if (zl>18) zl=18;
        return ghprecForZoomLevel[zl];
    };

	function heatMapColorforValue(value){
		var h = (1.0 - value) * 240
		return "hsl(" + h + ", 100%, 60%)";
	}

}