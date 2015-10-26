@extends('app')
@section('content')

<div>

    <!-- Heading -->
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
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