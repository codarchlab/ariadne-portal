@extends('app')
@section('content')

<div>

    <!-- Heading -->
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {!! Form::open(array("action" => "SearchController@search", "method" => "GET")) !!}            

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
                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                    </span>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <hr>

    <!-- Main content -->
    <div class="row">
        <div class="col-md-4">

        <p><strong>Total:</strong> <span class="badge">{{ $hits->total() }}</span></p>

        @foreach($aggregations as $key => $aggregation)
            @if(count($hits->aggregations[$key]['buckets']) > 0 || Input::has($key))
            <h4>{{ ucfirst($key) }}</h4>
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
                          <span class="badge">{{ $bucket['doc_count'] }}</span>
                          {{ $bucket['key'] }}
                    </a>
                @endif
              @endforeach                  
              
            </div>
            @endif
        @endforeach
        </div>
        <div class="col-md-8" id="search_results_box">                
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! $hits->appends(Input::all())->render() !!}
                </div>
                <hr/>
            </div>
            <div class="row">
            @foreach($hits as $hit)

                <div class="col-md-12" style="margin-bottom:30px;">
                    <div class="box box-primary" id="dataresource_item" item_id="{{ $hit['_id'] }}">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-1">
                                    <img src="{{ asset("img/monument.png") }}" height="50" border="0"> 
                                </div>
                                <div class="col-md-11">
                                    <strong>
                                        @if(array_key_exists('title', $hit['_source']))
                                            @if($hit['_type'] == 'database')
                                                <a href="{{ action('DatabaseController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'dataset')
                                                <a href="{{ action('DatasetController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'gis')
                                                <a href="{{ action('GisController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'collection')
                                                <a href="{{ action('CollectionController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'textualDocument')
                                                <a href="{{ action('TextualDocumentController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @else
                                                <a href="#{{ $hit['_type'] }} {{ $hit['_id'] }}">{{ $hit['_source']['title'] }}</a>   
                                            @endif
                                        @else
                                            <a href="#{{ $hit['_type'] }} {{ $hit['_id'] }}">[Title missing]</a>                                  
                                        @endif 
                                    </strong>
                                
                                    @if(array_key_exists('description', $hit['_source']))
                                        <p>{{ str_limit($hit['_source']['description'], 290) }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-1">
                                    type: <span class="badge">{{ $hit['_type'] }}</span>
                                </div>
                                <div class="col-md-3">
                                    @if(array_key_exists('issued', $hit['_source']))
                                    issued: <span class="badge">{{ $hit['_source']['issued'] }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if(array_key_exists('publisher', $hit['_source']) && count($hit['_source']['publisher']) >= 1)
                                    publisher: <span class="badge">{{ $hit['_source']['publisher'][0]['name'] }}</span>
                                    @endif
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>						

            @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! $hits->appends(Input::all())->render() !!}
                </div>
                <hr/>
            </div>
        </div>
    </div>

</div>

@endsection