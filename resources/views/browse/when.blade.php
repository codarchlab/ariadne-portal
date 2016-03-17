@extends('app')
@section('content')

<div class="container-fluid content">

	<div class="browse-container timeline">

		<div class="zoom-controls btn-toolbar controls">
			<div class="btn-group">
				<button type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-home"></span>
				</button>
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

	    <div id="chart" class="fullscreen" style="padding-top:50px;">

	    </div>

	</div>
    <script>
        var areaTimeline = new AreaTimeline(
        	"chart", window.location.href, true);
    </script>

</div>

@endsection