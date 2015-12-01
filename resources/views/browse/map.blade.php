@extends('app')

@section('content')

	<div class="map-controls">
		<a class="btn btn-primary" onclick="gridMap.triggerSearch()">
			<i class="glyphicon glyphicon-search"></i> {{ trans('map.trigger_search') }}
		</a>
	</div>

	<div class="fullscreen" id="map"></div>

	<script>
        var gridMap = new GridMap("map");
        gridMap.refreshGrid();
    </script>

@endsection