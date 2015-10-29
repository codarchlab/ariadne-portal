@if(count($buckets) > 0 || Input::has($key))
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
@endif