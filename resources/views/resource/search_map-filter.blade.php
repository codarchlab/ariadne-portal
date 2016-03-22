@if(count($buckets) > 0 || Input::has($key))

	<div class="panel panel-default">

		<div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">Where</h3>
        </div>

		<div class="filter-container map">

			<div class="pull-left controls-left btn-toolbar">
				<a class="btn btn-default btn-xs" href="{{ route('browse.where', Input::all()) }}"
						data-toggle="tooltip" data-container="body" data-placement="bottom" title="Show in fullscreen">
					<span class="glyphicon glyphicon-fullscreen"></span>
				</a>
			</div>

			<div class="pull-right controls controls-right btn-toolbar">
				<button type="button" class="btn btn-default btn-xs loading">
					<span class="glyphicon glyphicon-refresh spin"></span>
				</button>
				<button type="button" class="btn btn-default btn-xs btn-filter" onclick="gridMap.triggerSearch()" data-toggle="tooltip" data-placement="top" title="Show resources within area" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>

			<div class="map-container" id="map"></div>

		</div>

		<script>
	        var gridMap = new GridMap("map", window.location.href);
	    </script>

	</div>

@endif