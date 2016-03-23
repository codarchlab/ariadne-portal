@extends('app')
@section('title', 'Search - Ariadne portal')
@section('content')

<div class="container-fluid content">

    <!-- Main content -->
    <div class="row">
        
        <!-- Facets -->
        <div class="col-md-4">

            <h4>{{ trans('search.current_query') }}</h4>

            {!! Form::open(array("action" => "ResourceController@search", "method" => "GET", "id" => "searchPageForm")) !!}

                @if(Input::get('fields'))
                    <div id="activeFields">
                        <a href="{{ route('search', Utils::removeKeyValue('fields', Input::get('fields'))) }}"
                                class="list-group-item active">
                            <span class="badge"><span class="glyphicon glyphicon-remove"></span></span>
                            <b>{{ trans('search.fields') }}</b>: {{ trans('search.fields.'.Input::get('fields')) }}
                            {!! Form::hidden('fields', Input::get('fields')) !!}
                        </a>
                    </div>
                @endif

                <div class="input-group">
                    {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources...")) !!}
                    
                    <span class="input-group-btn">
                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary", "data-toggle" => "tooltip", "data-placement" => "top", "title" => "Refresh search")) !!}   
                    </span>
                </div>
            
                {!! Form::hidden('sort', Input::get('sort')) !!}
                {!! Form::hidden('order', Input::get('order')) !!}
            
                @foreach($hits->aggregations() as $key => $aggregation)
                  @if(Input::get($key))
                      {!! Form::hidden($key, Input::get($key)) !!}
                  @endif
                @endforeach
            {!! Form::close() !!}

            <!-- -->
            <h4>{{ trans('search.filters') }}</h4>

            <div id="activeFilters">
                @foreach($aggregations as $key => $aggregation)
                    @if($key != 'geogrid' && $key != 'temporal' && $key != 'range_buckets')
                        @include('resource.search_active-filters', [
                            'key' => $key,
                            'aggregation' => $aggregation,
                            'buckets' => $hits->aggregations()[$key]['buckets']
                        ])
                    @endif
                    @if($key == 'temporal')
                        @include('resource.search_active-filters', [
                            'key' => $key,
                            'aggregation' => $aggregation,
                            'buckets' => $hits->aggregations()[$key][$key]['buckets']
                        ])
                    @endif
                @endforeach
            </div>

            @include('resource.search_map-filter', [
                'buckets' => $hits->aggregations()['geogrid']['buckets']
            ])

            @include('resource.search_timeline-filter', [
                'buckets' => $hits->
                    aggregations()['range_buckets']['range_agg']['buckets'],
                'docCount' => $hits->aggregations()['range_buckets']['doc_count']
            ])

            @foreach($aggregations as $key => $aggregation)
                @if($key != 'geogrid' && $key != 'temporal'
                    && $key != 'range_buckets')
                    @include('resource.search_facet', [
                        'key' => $key,
                        'aggregation' => $aggregation,
                        'buckets' => $hits->aggregations()[$key]['buckets']
                    ])
                @endif
                @if($key == 'temporal')
                    @include('resource.search_facet', [
                        'key' => $key,
                        'aggregation' => $aggregation,
                        'buckets' => $hits->aggregations()[$key][$key]['buckets']
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
              <div class="col-md-12 text-right">
                <label for="sort">Order By</label>
                <select id="sort-action">
                  <option value="">Score</option>
                  @foreach(Config::get('app.elastic_search_sort') as $sort)
                  <option value="{{ $sort }}" @if(Request::input('sort') == $sort) selected @endif>{{ ucfirst($sort) }}</option>
                  @endforeach
                </select>

                @if(Request::has('order') == false || Request::input('order') == 'asc')
                  <a href="{{ route('search', Utils::addKeyValue('order', 'desc')) }}"><span class="glyphicon glyphicon-sort-by-attributes-alt" data-toggle="tooltip" data-placement="bottom" title="Descending"></span></a>
                @else
                  <a href="{{ route('search', Utils::removeKeyValue('order', 'desc')) }}"><span class="glyphicon glyphicon-sort-by-attributes" data-toggle="tooltip" data-placement="bottom" title="Ascending "></span></a>
                @endif
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