@extends('app')
@section('title', 'Browse / where - Ariadne portal')
@section('content')

<div class="container-fluid">

	<div class="browse-container map">

		<div class="controls-right controls panel panel-default">
			<div class="list-group">
				<div class="list-group-item">
					<span class="loading">
						<span class="glyphicon glyphicon-refresh spin"></span> <i>{{ trans('browse.loading') }}</i>
					</span>
					<span class="resource-count">
						<b><span class="count"></span></b> {{ trans('browse.resources_in_section') }}
					</span>
				</div>
				<button class="list-group-item btn-search" onclick="gridMap.triggerSearch()">
					<span class="glyphicon glyphicon-search"></span> {{ trans('browse.trigger_search') }}
				</button>
			</div>
		</div>


		<div class="fullscreen" id="map"></div>

	</div>

	<script>
        var gridMap = new GridMap("map", window.location.href);
    </script>

</div>

@endsection