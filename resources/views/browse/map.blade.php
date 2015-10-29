@extends('app')

@section('content')

	<div class="fullscreen" id="map"></div>

	<script>

        function heatMapColorforValue(value){
          var h = (1.0 - value) * 240
          return "hsl(" + h + ", 100%, 80%)";
        }

        var map = L.map("map").setView([40, 17], 3);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var grid = {!! json_encode($grid) !!};
        var max = grid[0]['doc_count'];

        grid.forEach(function(bucket) {
        	var corners = Geohash.bounds(bucket['key']);
        	var bounds = L.latLngBounds(corners.sw, corners.ne);
            var heat = Math.pow(bucket['doc_count'] / max, 1/5); // add curve to accomodate for long-tail distibution
        	L.rectangle(bounds, {color: heatMapColorforValue(heat), weight: 1}).addTo(map);
        	var label = L.marker(bounds.getCenter(), {
        		icon: L.divIcon({
        			className: 'grid-label-container',
        			html: '<div class="grid-label">'+bucket['doc_count'].toLocaleString('en-US')+'</div>'
        		}),
        		zIndexOffset: 1000
        	}).addTo(map);
        });

    </script>

@endsection