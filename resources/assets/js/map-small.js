function SmallMap(spatialItems,nearbySpatialItems) {

    var initializeMap = function() {
        var map = L.map("map");
        map.setView([0, 17], 0);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.Icon.Default.imagePath = '/img/leaflet/default';

        return map;
    };

    var markerIconForColor = function(markerColor) {

        var markerFilePath = '/img/leaflet/default/marker-icon.png';
        if (markerColor)
            markerFilePath = '/img/leaflet/custom/marker-icon-' + markerColor + '.png';

        var markerIcon = L.icon({
            iconUrl: markerFilePath,
            iconSize: [25, 41],
            iconAnchor: [12, 40],
            shadowUrl: '/img/leaflet/default/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 40]
        });

        return markerIcon;
    };

    var markerOptions = function(priority,markerColor) {
        var markerOptions = { icon: markerIconForColor(markerColor), riseOnHover: true};
        if (priority)
            markerOptions.zIndexOffset = 1000;
        return markerOptions;
    };

    var labelOptions = function() {
        return {
            className: "marker-label"
        }
    };

    var makeMarker = function(spatial,priority,markerColor) {
        var marker = L.marker(spatial.location, markerOptions(priority,markerColor));
        var label = spatial.placeName ? spatial.placeName
            : spatial.location.lat + ", " + spatial.location.lon;
        marker.bindLabel(label, { className: "marker-label" });
        marker.on('click', function(e) {
            var q = "spatial.location.lon:\"" + spatial.location.lon
                + "\" AND spatial.location.lat:\"" + spatial.location.lat + "\"";
            window.location.href = new Query(q).toUri();
        });
        return marker;
    };

    var createMarkers = function(spatialItems, priority, markerColor) {
        var markers = [];

        for (var i = 0; i<spatialItems.length; i++)
            markers.push(makeMarker(spatialItems[i],priority,markerColor));

        return markers;
    };

    var showMarkers = function(map,markers) {
        for (var i in markers) {
            markers[i].addTo(map);
        }
    };

    var fitViewportToMarkers = function(map,markers) {
        var group = L.featureGroup(markers);
        map.fitBounds(group.getBounds());
    };


    // Main

    var markers = [];
    markers = markers.concat(createMarkers(nearbySpatialItems, false, 'blue'));
    markers = markers.concat(createMarkers(spatialItems, true, 'red'));

    var map = initializeMap();
    showMarkers(map,markers);
    fitViewportToMarkers(map,markers);
}