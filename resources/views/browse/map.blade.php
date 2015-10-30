@extends('app')

@section('content')

	<div class="fullscreen" id="map"></div>

	<script>
        var gridMap = new GridMap("map");
        gridMap.refreshGrid();
    </script>

@endsection