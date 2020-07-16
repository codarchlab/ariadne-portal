@extends('app')
@section('title', 'Browse / when - Ariadne portal')
@section('content')

<div class="container-fluid content">
	<div class="browse-container timeline">

		<div class="zoom-controls btn-toolbar controls">
			<div class="btn-group">
				<a class="btn btn-default" href="{{ action('PageController@welcome') }}"
						data-toggle="tooltip" data-container="body" data-placement="bottom" title="Return to home page">
					<span class="glyphicon glyphicon-home"></span>
				</a>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="areaTimeline.zoomOut()"
						data-toggle="tooltip" data-container="body" data-placement="bottom" title="Zoom out">
					<span class="glyphicon glyphicon-minus"></span>
				</button>
				<button type="button" class="btn btn-default" onclick="areaTimeline.zoomIn()"
						data-toggle="tooltip" data-container="body" data-placement="bottom" title="Zoom in">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
			</div>
			<div class="btn-group">
				<span class="btn btn-default loading">
					<span class="glyphicon glyphicon-refresh spin"></span>
				</span>
			</div>
		</div>

		<div class="brush-controls-container">
			<div class="brush-controls" style="display: none;">
				<div><code class="timespan"></code></div>
				<div class="btn-group-vertical">
					<button type="button" class="btn btn-link" onclick="areaTimeline.zoomIn()"
						data-toggle="tooltip" data-container="body" data-placement="right" title="Zoom into selected area">
						<span class="glyphicon glyphicon-zoom-in"></span>
					</button>
					<button type="button" class="btn btn-link" onclick="areaTimeline.triggerSearch()"
						data-toggle="tooltip" data-container="body" data-placement="right" title="Search for resources in the selected area">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
		</div>

	    <div class="fullscreen timeline-container">

	    </div>

	</div>
    <script>
        var areaTimeline = new AreaTimeline(
        	".timeline-container", window.location.href, true);
    </script>

</div>

@endsection