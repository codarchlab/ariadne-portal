<?php debug($hit)?>
<div class="col-md-12 hit">
    <div class="box box-primary" id="dataresource_item" item_id="{{ $hit['_id'] }}">
        <div class="box-body">
            <div class="row">
                <div class="col-md-1">
                    <img src="{{ asset("img/monument.png") }}" height="50" border="0"> 
                </div>
                <div class="col-md-10">
                    <div class="row">
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

                        @if(array_key_exists('highlight', $hit))
                            <h5>Matches found</h5>
                            @foreach($hit['highlight'] as $key => $values)
                                <p class="highlights">
                                   <strong>{{ $key }}</strong>:  
                                   @foreach($values as $key => $value)
                                   {!! $value !!}
                                   @endforeach
                                </p>
                            @endforeach
                        @endif
                        @if(array_key_exists('description', $hit['_source']))
                            <p>{{ str_limit($hit['_source']['description'], 290) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    type: <span class="badge">{{ $hit['_type'] }}</span>
                </div>
                <div class="col-md-2">
                    @if(array_key_exists('issued', $hit['_source']))
                    issued: <span class="badge">{{ $hit['_source']['issued'] }}</span>
                    @endif
                </div>
                <div class="col-md-3">
                    @if(array_key_exists('publisher', $hit['_source']) && count($hit['_source']['publisher']) >= 1)
                    publisher: <span class="badge">{{ $hit['_source']['publisher'][0]['name'] }}</span>
                    @endif
                </div>                                    
            </div>
        </div>
    </div>
</div>