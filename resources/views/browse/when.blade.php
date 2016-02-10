@extends('app')
@section('content')

<div class="container-fluid">

	<style>
		.axis path,
	    .axis line {
	        fill: none;
	        stroke: #121401;
	        stroke-width: 2px;
	        shape-rendering: crispEdges;
	    }
	    .brush .extent {
		  fill-opacity: .125;
		  shape-rendering: crispEdges;
		}
	</style>

    <div id="chart">

    </div>
    <script>
        //var bucketTimeline = new BucketTimeline("chart").renderIntoDOM(-6000,2016);
        var areaTimeline = new AreaTimeline(
        	"chart", window.location.href,
        	-1000000, 2016);
    </script>

</div>

@endsection