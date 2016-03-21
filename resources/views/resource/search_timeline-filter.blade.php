@if(count($buckets) > 0 || Input::has($key))

	<div class="panel panel-default">

		<div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">When</h3>
        </div>

		<div class="filter-container timeline">

			<div class="pull-right controls btn-toolbar">
				<button type="button" class="btn btn-default btn-xs loading">
					<span class="glyphicon glyphicon-refresh spin"></span>
				</button>
			</div>

			<div class="zoom-controls panel">
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
	        var areaTimeline = new AreaTimeline(".timeline-container", window.location.href, false);
	    </script>

	</div>

@endif