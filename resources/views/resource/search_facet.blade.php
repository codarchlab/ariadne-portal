@if(count($buckets) > 0 || Input::has($key))

    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="heading_{{$key}}">
            <h3 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$key}}"
                   aria-expanded="<?php echo($key == 'archaeologicalResourceType') ? 'true' : 'false' ?>" aria-controls="collapse_{{$key}}">
                    {{ trans('resource.'.$key) }}
                </a>
            </h3>
        </div>

        <div id="collapse_{{$key}}" class="panel-collapse collapse <?php echo($key == 'archaeologicalResourceType') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading_{{$key}}">

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

                @foreach($buckets as $bucket)
                    @if(Utils::keyValueActive($key, $bucket['key']) == false)
                        <a href="{{ route('search', Utils::addKeyValue($key, $bucket['key'])) }}" class="list-group-item">
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