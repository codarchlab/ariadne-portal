@extends('app')
@section('content')

<div class="container-fluid content">

	<div class="browse-container timeline">

		<div class="controls panel panel-default">
			<div class="list-group">
				<div class="list-group-item">
					<span class="loading">
						<span class="glyphicon glyphicon-refresh spin"></span> <i>{{ trans('browse.loading') }}</i>
					</span>
					<span class="resource-count">
						<b><span class="count"></span></b> {{ trans('browse.resources_in_section') }}
					</span>
				</div>
				<button class="list-group-item btn-search" onclick="areaTimeline.triggerSearch()">
					<span class="glyphicon glyphicon-search"></span> {{ trans('browse.trigger_search') }}
				</button>
			</div>
		</div>

		<div class="zoom-controls panel panel-default">
			<div class="list-group">
				<button class="list-group-item btn btn-default btn-zoom-in btn-sm" onclick="areaTimeline.zoomIn()">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
				<button class="list-group-item btn btn-default btn-zoom-out disabled btn-sm" 
						onclick="areaTimeline.zoomOut()">
					<span class="glyphicon glyphicon-minus"></span>
				</button>
			</div>
		</div>

	    <div id="chart">

	    </div>

	</div>
    <script>
        //var bucketTimeline = new BucketTimeline("chart").renderIntoDOM(-6000,2016);
        var areaTimeline = new AreaTimeline(
        	"chart", window.location.href,
        	-1000000, 2016);
    </script>

</div>

@endsection