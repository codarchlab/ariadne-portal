<div class="col-md-12 hit" onclick="window.location.href = '{{ route('resource.page', $hit['_id']) }}'">
    <div class="box box-primary" id="dataresource_item" item_id="{{ $hit['_id'] }}">
        <div class="box-body">
            <div class="row">
                <div class="col-md-1">

                    <img src="{{ asset("img/icons/")."/icon_".$hit['_source']['resourceType'].".png" }}" height="50" border="0">

                </div>
                <div class="col-md-11">

                    <h5>
                        <a href="{{ route('resource.page', $hit['_id']) }}">
                            @if(array_key_exists('highlight', $hit) && array_key_exists('title', $hit['highlight']))
                                {!! $hit['highlight']['title'][0] !!}
                            @elseif(array_key_exists('title', $hit['_source']))
                                {{ $hit['_source']['title'] }}
                            @else
                                {{ trans('resource.title_missing') }}
                            @endif
                       </a>
                        @if (isset($hit['_source']['landingPage']))  
                            <div class="pull-right">
                                <a class="button land" href="{{ $hit['_source']['landingPage']}}" target="_blank">
                                    <span class="glyphicon glyphicon-new-window" data-toggle="tooltip" data-placement="bottom" title="Landing page"></span>
                                </a> 
                            </div>
                        @endif
                    </h5>

                    <p>
                        {{ trans('resource.resourceType') }}:
                        <span class="badge">{{ $hit['_source']['archaeologicalResourceType']['name'] }}</span>
                        @if(array_key_exists('publisher', $hit['_source']) && count($hit['_source']['publisher']) >= 1)
                            {{ trans('resource.publisher') }}:
                            <span class="badge">{{ $hit['_source']['publisher'][0]['name'] }}</span>
                        @endif                                  
                    </p>

                    @if(array_key_exists('highlight', $hit) && array_key_exists('description', $hit['highlight']))
                        @foreach($hit['highlight']['description'] as $key => $value)
                            <p>{!! $value !!}</p>
                        @endforeach
                    @elseif(array_key_exists('description', $hit['_source']))
                        <p>{{ str_limit(strip_tags($hit['_source']['description']), 290) }}</p>
                    @endif                    

                    @if(array_key_exists('highlight', $hit))
                        @foreach($hit['highlight'] as $key => $values)
                            @if($key != 'title' && $key != 'description')
                                <p class="highlights">
                                    <strong>{{ trans('resource.'.$key) }}</strong>:  
                                    @foreach($values as $key => $value)
                                        {!! $value !!}
                                    @endforeach
                                </p>
                            @endif
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>   

<script>
    $( ".land" ).click(function( event ) {
        event.stopPropagation();
        // Do something
    }); 
</script>