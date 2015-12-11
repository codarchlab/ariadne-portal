@extends('app')
@section('title', 'Search - Ariadne portal')
@section('content')

<div class="container-fluid content">

    <!-- Main content -->
    <div class="row">
        
        <!-- Facets -->
        <div class="col-md-4">

            <h4>{{ trans('search.current_query') }}</h4>

            {!! Form::open(array("action" => "ResourceController@search", "method" => "GET")) !!}

                <div class="input-group">
                    {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources...")) !!}

                    @foreach($hits->aggregations() as $key => $aggregation)
                        @if(Input::get($key))
                            {!! Form::hidden($key, Input::get($key)) !!}
                        @endif
                    @endforeach

                    <span class="input-group-btn">
                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                    </span>
                </div>
            {!! Form::close() !!}

            <!-- -->
            <h4>{{ trans('search.filters') }}</h4>

            <div id="activeFilters">
                @foreach($aggregations as $key => $aggregation)
                    @if($key != 'geogrid')
                        @include('resource.search_active-filters', [
                            'key' => $key,
                            'aggregation' => $aggregation,
                            'buckets' => $hits->aggregations()[$key]['buckets']
                        ])
                    @endif
                @endforeach
            </div>

            @include('resource.search_map-filter', [
                'buckets' => $hits->aggregations()[$key]['buckets']
            ])

            @foreach($aggregations as $key => $aggregation)
                @if($key != 'geogrid')
                    @include('resource.search_facet', [
                        'key' => $key,
                        'aggregation' => $aggregation,
                        'buckets' => $hits->aggregations()[$key]['buckets']
                    ])
                @endif
            @endforeach

        </div>
        
        <!-- Results -->
        <div class="col-md-8" id="search_results_box">            
            <div class="row">
                <div class="col-md-3 total">
                    <strong>{{ trans('search.total') }}:</strong> <span class="badge">{{ number_format($hits->total()) }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <small>{!! $hits->appends(Input::all())->render() !!}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><hr/></div>
            </div>
            <div class="row">
                @foreach($hits as $hit)
                    @include('resource.search_hit', ['hit' => $hit])
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12"><hr/></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <small>{!! $hits->appends(Input::all())->render() !!}</small>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection