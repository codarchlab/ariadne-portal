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
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- search form -->                
                    {!! Form::open(array("action" => "SearchController@search", "method" => "GET")) !!}                
                    <div class="input-group">
                        {!! Form::text("q", Request::input('q'), array("id" => "q", "class" => "form-control", "placeholder" => "Search for data resource...")) !!}
                        <span class="input-group-btn">
                            {!! Form::submit("Search", array("class" => "btn btn-flat form-control", "style" => "border:1px #c0c0c0 solid;")) !!}
                        </span>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-3">
                @foreach($hits->aggregations as $key => $aggregation)
                @if(count($aggregation['buckets']) > 0)
                <h3>{{ $key }}</h3>
                <div class="list-group">
                  @foreach($aggregation['buckets'] as $bucket)
                  
                  @if(Utils::keyValueActive($key, $bucket['key']))
                  <a href="{{ route('search', Utils::removeKeyValue($key, $bucket['key'])) }}" class="list-group-item active">
                        <span class="badge">{{ $bucket['doc_count'] }}</span>
                        {{ $bucket['key'] }}
                  </a>                  
                  @else
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
                    <p><strong>Total:</strong> {{ $hits->total() }}</p>
                    {!! $hits->appends(['q' => Request::input('q')])->render() !!}
                </div>              
                <div class="row"><div class="col-md-8"><hr/></div></div>
                @foreach($hits as $hit)

                    <div class="col-md-6">
                        <div class="box box-primary" id="dataresource_item" item_id="{{ $hit['_id'] }}">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ asset("img/monument.png") }}" height="50" border="0"> 
                                    </div>
                                    <div class="col-md-10">
                                        @if(array_key_exists('title', $hit['_source']))
                                            @if($hit['_type'] == 'database')
                                                <a href="{{ action('DatabaseController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'dataset')
                                                <a href="{{ action('DatasetController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'gis')
                                                <a href="{{ action('GisController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @elseif($hit['_type'] == 'collection')
                                                <a href="{{ action('CollectionController@show', $hit['_id']) }}">{{ $hit['_source']['title'] }}</a>
                                            @endif
                                        @else
                                            <a href="#{{ $hit['_type'] }} {{ $hit['_id'] }}">[Title missing]</a>                                  
                                        @endif   
                                        </a>
                                    </div>
                                </div></br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <br/><br/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        type: <b>{{ $hit['_type'] }}</b><br/>
                                        
                                        @if(array_key_exists('subject', $hit['_source']))
                                        {{ $hit['_source']['subject'] }}
                                        @endif
                                    </div>
                                    <div class="col-md-2 pull-right">         
                                        <br/><br/><a href="#" id="dr_item_href" item_id="{{ $hit['_id']  }}" data-toggle="modal" data-target="#item-modal">more...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>						

                @endforeach
            </div>
        </div>
        <div class="row">
            {!! $hits->appends(['q' => Request::input('q')])->render() !!}
        </div>
   </section>             
</aside>
@endsection