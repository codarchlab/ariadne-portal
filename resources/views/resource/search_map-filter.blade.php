@if(count($buckets) > 0 || Input::has($key))

	<div class="panel panel-default">

		<div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">Where</h3>
        </div>

		<div class="filter-map-container">

			<div class="pull-right map-controls btn-toolbar">
				<button type="button" class="btn btn-default btn-xs loading">
					<span class="glyphicon glyphicon-refresh spin"></span>
				</button>
				<button type="button" class="btn btn-default btn-xs btn-filter" onclick="gridMap.triggerSearch()" data-toggle="tooltip" data-placement="top" title="Show resources within area" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>

			<div class="map" id="map"></div>

		</div>

		<script>
	        var gridMap = new GridMap("map", window.location.href);
	    </script>

	</div>

@endif