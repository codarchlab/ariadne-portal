@extends('app')
@section('content')

<div class="container-fluid content">

	<div class="browse-container timeline">

		<div class="zoom-controls btn-toolbar controls">
			<div class="btn-group">
				<a class="btn btn-default" href="{{ action('PageController@welcome') }}">
					<span class="glyphicon glyphicon-home"></span>
				</a>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="areaTimeline.zoomOut()">
					<span class="glyphicon glyphicon-zoom-out"></span>
				</button>
				<button type="button" class="btn btn-default" onclick="areaTimeline.zoomIn()">
					<span class="glyphicon glyphicon-zoom-in"></span>
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
					<button type="button" class="btn btn-link" onclick="areaTimeline.zoomIn()">
						<span class="glyphicon glyphicon-zoom-in"></span>
					</button>
					<button type="button" class="btn btn-link" onclick="areaTimeline.triggerSearch()">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
		</div>

	    <div id="chart" class="fullscreen" style="padding-top:80px;">

	    </div>

	</div>
    <script>
        var areaTimeline = new AreaTimeline(
        	"chart", window.location.href, true);
    </script>

</div>

@endsection