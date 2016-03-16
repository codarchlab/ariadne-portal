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
				<button type="button" class="btn btn-default btn-xs btn-filter" onclick="areaTimeline.triggerSearch()" data-toggle="tooltip" data-placement="top" title="Show resources within timespan" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>

			<div class="zoom-controls panel panel-default">
				<div class="list-group">
					<button class="list-group-item btn btn-default btn-zoom-in btn-sm" onclick="areaTimeline.zoomIn()">
						+
					</button>
					<button class="list-group-item btn btn-default btn-zoom-out disabled btn-sm" 
							onclick="areaTimeline.zoomOut()">
						-
					</button>
				</div>
			</div>

			<div class="timeline-container" id="timeline"></div>

		</div>

		<script>
	        var areaTimeline = new AreaTimeline("timeline", window.location.href, false);
	    </script>

	</div>

@endif