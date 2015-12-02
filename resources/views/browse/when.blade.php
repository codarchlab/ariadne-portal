@extends('app')
@section('content')

    <div class="fullscreen" id="chart" style="height:200px; width: 800px;"></div>
    <script>
        var barChart = new BarChart("chart");
        barChart.present(1100,1250);
    </script>

@endsection