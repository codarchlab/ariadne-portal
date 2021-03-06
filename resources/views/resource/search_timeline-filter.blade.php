@if(count($buckets) > 0 && $docCount > 0)

	<div class="panel panel-default">

		<div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">When</h3>
        </div>

		<div class="filter-container timeline">

			<div class="pull-right controls-right controls btn-toolbar">
				<button type="button" class="btn btn-default btn-xs loading">
					<span class="glyphicon glyphicon-refresh spin"></span>
				</button>	
				<button type="button" class="btn btn-default btn-xs btn-remove" onclick="areaTimeline.removeRange()"
				data-toggle="tooltip" data-placement="top" title="Remove filter" >
					<span class="glyphicon glyphicon-remove"></span>
				</button>			
				<button type="button" class="btn btn-default btn-xs btn-filter" onclick="areaTimeline.triggerSearch()" data-toggle="tooltip" data-placement="top" title="Show resources within timespan" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>

			<div class="zoom-controls btn-toolbar">
				<div class="btn-group">
					<button class="btn btn-default btn-zoom-out btn-xs" onclick="areaTimeline.zoomOut()"
							data-toggle="tooltip" data-container="body" data-placement="bottom" title="Zoom out">
						<span class="glyphicon glyphicon-minus"></span>
					</button>
					<button class="btn btn-default btn-zoom-in btn-xs" onclick="areaTimeline.zoomIn()"
							data-toggle="tooltip" data-container="body" data-placement="bottom" title="Zoom in">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</div>
				<div class="btn-group">
					<a class="btn btn-default btn-xs" href="{{ route('browse.when', Input::all()) }}"
							data-toggle="tooltip" data-container="body" data-placement="bottom" title="Show in fullscreen">
						<span class="glyphicon glyphicon-fullscreen"></span>
					</a>
				</div>
			</div>

			<div class="brush-controls-container">
				<div class="brush-controls" style="display: none;">
					<div><code class="timespan"></code></div>
					<div class="btn-group-vertical">
						<button type="button" class="btn btn-link btn-sm" onclick="areaTimeline.zoomIn()"
							data-toggle="tooltip" data-container="body" data-placement="right" title="Zoom into selected area">
							<span class="glyphicon glyphicon-zoom-in"></span>
						</button>
						<button type="button" class="btn btn-link btn-sm" onclick="areaTimeline.triggerSearch()"
							data-toggle="tooltip" data-container="body" data-placement="right" title="Search for resources in the selected area">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				</div>
			</div>

			<div class="timeline-container"></div>

		</div>

		<script>
			var buckets = JSON.parse('{!! json_encode($buckets) !!}');
	        var areaTimeline = new AreaTimeline(".timeline-container", window.location.href, false, buckets);
	    </script>

	</div>

@endif