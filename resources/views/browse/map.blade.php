@extends('app')

@section('content')

	<div class="fullscreen" id="map"></div>

	<script>

        var map = L.map("map").setView([40, 17], 3);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var grid = {!! json_encode($grid) !!};

        grid.forEach(function(bucket) {
        	console.log(bucket);
        	var corners = Geohash.bounds(bucket['key']);
        	var bounds = L.latLngBounds(corners.sw, corners.ne);
        	L.rectangle(bounds, {color: "#ff7800", weight: 1}),bindLabel(bucket['doc_count']).addTo(map);
        });

    </script>

@endsection