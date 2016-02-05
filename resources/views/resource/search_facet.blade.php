@if(count($buckets) > 0 || Input::has($key))

    <div class="panel panel-default aggregation" data-aggregation="{{$key}}">

        <div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">
                @if($key == 'archaeologicalResourceType')
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$key}}"
                   aria-expanded="true" aria-controls="collapse_{{$key}}">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    {{ trans('resource.'.$key) }}
                </a>
                @else
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$key}}"
                   aria-expanded="false" aria-controls="collapse_{{$key}}">
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    {{ trans('resource.'.$key) }}
                </a>
                @endif
            </h3>
        </div>

        <div id="collapse_{{$key}}" class="panel-collapse collapse <?php echo($key == 'archaeologicalResourceType') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading_{{$key}}">

            <div class="list-group aggregation-items">

                @if(Input::has($key))
                    @foreach(Utils::getArgumentValues($key) as $value)
                        @if(Utils::keyValueActive($key, $value))
                        <a href="{{ route('search', Utils::removeKeyValue($key, $value)) }}" class="list-group-item value active">
                            <span class="badge"><span class="glyphicon glyphicon-remove"></span></span>
                            {{ $value }}
                        </a>
                        @endif
                    @endforeach
                @endif

                @foreach($buckets as $bucket)
                    @if(Utils::keyValueActive($key, $bucket['key']) == false)
                        <a href="{{ route('search', Utils::addKeyValue($key, $bucket['key'])) }}" class="list-group-item value">
                            <span class="badge">{{ number_format($bucket['doc_count']) }}</span>
                            @if(in_array($key, $translateAggregations))
                                {{ trans('resource.' . $key . '.' . $bucket['key']) }}
                            @else
                                {{ $bucket['key'] }}
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>

        </div>

    </div>

@endif