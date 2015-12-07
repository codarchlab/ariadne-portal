@extends('app')
@section('content')

    <div class="fullscreen" id="chart" style="position: absolute; top: 100px; left: 40px; height:400px; width: 1200px;">

    </div>
    <script>
        var start=<?php echo $start;?>;
        var end=<?php echo $end;?>;

        var barChart = new BarChart("chart");
        barChart.present(start,end);
    </script>

@endsection