@if(count($buckets) > 0 || Input::has($key))

    @if(Input::has($key))

        @foreach(Utils::getArgumentValues($key) as $value)
            @if(Utils::keyValueActive($key, $value))

                <a href="{{ route('search', Utils::removeKeyValue($key, $value)) }}" class="list-group-item active">
                    <span class="badge"><span class="glyphicon glyphicon-remove"></span></span>
                    <b>{{ trans('resource.'.$key) }}</b>: {{ $value }}
                </a>

            @endif
        @endforeach

    @endif

@endif