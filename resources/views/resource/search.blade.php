@extends('app')
@section('content')

<div>

    <!-- Main content -->
    <div class="row">
        
        <!-- Facets -->
        <div class="col-md-4">

            <h4>{{ trans('search.current_query') }}</h4>

            {!! Form::open(array("action" => "ResourceController@search", "method" => "GET")) !!}

                <div class="input-group">
                    {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources...")) !!}

                    @if(isset($hits->aggregations))
                        @foreach($hits->aggregations as $key => $aggregation)
                            @if(Input::get($key))
                                {!! Form::hidden($key, Input::get($key)) !!}
                            @endif
                        @endforeach
                    @endif

                    <span class="input-group-btn">
                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                    </span>
                </div>
            {!! Form::close() !!}

            <h4>{{ trans('search.filters') }}</h4>

            @foreach($aggregations as $key => $aggregation)
                @if(count($hits->aggregations[$key]['buckets']) > 0 || Input::has($key))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('resource.'.$key) }}</h3>
                        </div>
                        <div class="list-group">
                            @if(Input::has($key))
                                @foreach(Utils::getArgumentValues($key) as $value)
                                    @if(Utils::keyValueActive($key, $value))
                                        <a href="{{ route('search', Utils::removeKeyValue($key, $value)) }}" class="list-group-item active">
                                            <span class="badge"><span class="glyphicon glyphicon-remove"></span></span>
                                            {{ $value }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                      
                            @foreach($hits->aggregations[$key]['buckets'] as $bucket)
                                @if(Utils::keyValueActive($key, $bucket['key']) == false)
                                    <a href="{{ route('search', Utils::addKeyValue($key, $bucket['key'])) }}" class="list-group-item">
                                        <span class="badge">{{ number_format($bucket['doc_count']) }}</span>
                                        {{ $bucket['key'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>               
                      
                    </div>
                @endif
            @endforeach

        </div>
        
        <!-- Results -->
        <div class="col-md-8" id="search_results_box">            
            <div class="row">
                <div class="col-md-12 text-center">
                    <p><strong>Total:</strong> <span class="badge">{{ number_format($hits->total()) }}</span></p>
                    {!! $hits->appends(Input::all())->render() !!}
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
                <div class="col-md-12 text-center">
                    {!! $hits->appends(Input::all())->render() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><hr/></div>
            </div>
        </div>
    </div>

</div>

@endsection