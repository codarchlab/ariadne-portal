@extends('app')

@section('content')

	<div class="browse-map-container">

		<div class="map-controls panel panel-default">
			<div class="list-group">
				<div class="list-group-item">
					<span class="loading">
						<span class="glyphicon glyphicon-refresh spin"></span> <i>{{ trans('map.loading') }}</i>
					</span>
					<span class="resource-count">
						<b><span class="count"></span></b> {{ trans('map.resources_in_section') }}
					</span>
				</div>
				<button class="list-group-item btn-search" onclick="gridMap.triggerSearch()">
					<span class="glyphicon glyphicon-search"></span> {{ trans('map.trigger_search') }}
				</button>
			</div>
		</div>

		<div class="fullscreen" id="map"></div>

	</div>

	<script>
        var gridMap = new GridMap("map", window.location.href);
        gridMap.refreshMap();
    </script>

@endsection