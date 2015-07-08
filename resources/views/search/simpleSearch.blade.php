@extends('app')
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->        
<aside class="right-side">                
    <!-- Main content -->
    <section class="content-header">
        <h1>
            Search
            <small>Here you can search all available data resources </small>
        </h1>
        <hr>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2">

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
                    <div class="col-md-8">               
                        {!! Form::open(array("action" => "SearchController@search", "method" => "GET", "class" => "form-inline")) !!}            

                            {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "style" => "width:60%", "placeholder" => "Search for resources...")) !!}

                            @if(isset($hits->aggregations))
                                @foreach($hits->aggregations as $key => $aggregation)
                                    @if(Input::get($key))
                                        {!! Form::hidden($key, Input::get($key)) !!}
                                    @endif
                                @endforeach
                            @endif

                            {!! Form::submit("Search", array("class" => "btn btn-primary")) !!}
                        {!! Form::close() !!}
                        <div class="row">
                        @foreach($aggregations as $key => $aggregation)
                            @if(Input::has($key))
                                @foreach(Utils::getArgumentValues($key) as $value)
                                    @if(Utils::keyValueActive($key, $value))
                                    <a href="{{ route('search', Utils::removeKeyValue($key, $value)) }}" style="margin-right: 4px" class="label label-info">
                                        <span class="text-info">{{ ucfirst($key) }}:</span> {{ $value }} 
                                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </a> 
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </div>
                    </div>

                </div>                
                <div class="row">
                    <p><strong>Total:</strong> {{ $hits->total() }}</p>
                    {!! $hits->appends(Input::all())->render() !!}
                </div>              
                <div class="row"><div class="col-md-8"><hr/></div></div>
                <div class="row">
                @foreach($hits as $hit)

                    <div class="col-md-12">
                        <div class="box box-primary" id="dataresource_item" item_id="{{ $hit['_id'] }}">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="{{ asset("img/monument.png") }}" height="50" border="0"> 
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                        @if(array_key_exists('title', $hit['_source']))
                                            @if($hit['_type'] == 'database')
                                                <a href="{{ action('DatabaseController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'dataset')
                                                <a href="{{ action('DatasetController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'gis')
                                                <a href="{{ action('GisController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'collection')
                                                <a href="{{ action('CollectionController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @else
                                                <a href="#{{ $hit['_type'] }} {{ $hit['_id'] }}">{{ $hit['_source']['title'] }}</a>   
                                            @endif
                                        @else
                                            <a href="#{{ $hit['_type'] }} {{ $hit['_id'] }}">[Title missing]</a>                                  
                                        @endif   
                                        </a>
                                        </div>
                                        @if(array_key_exists('description', $hit['_source']))
                                            {{ str_limit($hit['_source']['description'], 290) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        type: <b>{{ $hit['_type'] }}</b><br/>
                                        
                                        @if(array_key_exists('subject', $hit['_source']))
                                        {{ $hit['_source']['subject'] }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>						

                @endforeach
                </div>
                <div class="row">
                    {!! $hits->appends(Input::all())->render() !!}
                </div>
            </div>
        </div>

   </section>             
</aside>
@endsection