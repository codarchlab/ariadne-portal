@extends('app')

@section('content')

	<div class="fullscreen" id="map"></div>

	<script>

        var map = L.map("map").setView([40, 17], 3);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

    </script>

@endsection