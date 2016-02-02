@extends('app')
@section('content')

<div class="container-fluid">

    <div class="fullscreen" id="chart" style="position: absolute; top: 100px; left: 40px; height:400px; width: 1200px;">

    </div>
    <script>
        var bucketTimeline = new BucketTimeline("chart");
        bucketTimeline.renderIntoDOM(-100000000,2016);
    </script>

</div>

@endsection