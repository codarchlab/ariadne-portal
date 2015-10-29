@extends('app')
@section('content')

<div class="row">

    <!-- resoure metadata -->
    <div class="col-md-8 resource-metadata">
        <h3>{{ $resource['_source']['title'] }}</h3>

        <div>
            @if (isset($resource['_source']['landingPage']))
                <a href="{{ $resource['_source']['landingPage']}}" target="_blank">
                    <span class="glyphicon glyphicon-globe"></span> {{ trans('resource.landing_page') }}
                </a>
            @endif

            <!-- TODO Add contact information when available in data. See mockups. -->

            <div class="pull-right">
                <!-- TODO Enable button when endpoint for export is available. -->
                <a>
                    <span class="glyphicon glyphicon-file"></span>
                </a>
                <!-- TODO Open modal for copying citation. -->
                <a>
                    <span class="glyphicon glyphicon-link"></span>
                </a>
            </div>
        </div>

        @if (isset($resource['_source']['description']))
            <div>
                {{$resource['_source']['description']}}
            </div>
        @endif

        @if (isset($resource['_source']['nativeSubject']))
            <div>
                @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
                    <a class="tag" href="{{ route('search', [ 'nativeSubject' => $nativeSubject['prefLabel'] ]) }}">
                        <span class="glyphicon glyphicon-tag"></span>
                        {{ $nativeSubject['prefLabel'] }}
                    </a>
                @endforeach
            </div>
        @endif

        @if (isset($resource['_source']['temporal']))
        <div>
            @foreach ($resource['_source']['temporal'] as $temporal)
                @if(isset($temporal['periodName']))
                    <a class="tag" href="{{ route('search', [ 'temporal' => $temporal['periodName'] ]) }}">
                        <span class="glyphicon glyphicon-time"></span>
                        {{ $temporal['periodName'] }}
                    </a>
                @endif
            @endforeach
        </div>
        @endif

        @if (isset($resource['_source']['spatial']))
            <div>
                @foreach ($resource['_source']['spatial'] as $spatial)
                    @if(isset($spatial['placeName']))
                        <a class="tag" href="{{ route('search', [ 'spatial' => $spatial['placeName'] ]) }}">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $spatial['placeName'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <h4>{{ trans('resource.metadata') }}</h4>

        <dl class="dl-horizontal">


            @if (isset($resource['_id']))
                <dt>{{ trans('resource.identifier') }}</dt>
                <dd>{{ $resource['_id'] }}</dd>
            @endif

            @if (isset($resource['_type']))
                <dt>{{ trans('resource.type') }}</dt>
                <dd>{{ trans('resource.type.'.$resource['_type']) }}</dd>
            @endif

            @if (isset($resource['_source']['language']))
                <dt>{{ trans('resource.language') }}</dt>
                <dd>{{ trans('resource.language.'.$resource['_source']['language']) }}</dd>
            @endif

            @if (isset($resource['_source']['archaeologicalResourceType']))
                <dt>{{ trans('resource.archaeologicalResourceType') }}</dt>
                <dd>{{ $resource['_source']['archaeologicalResourceType']['name'] }}</dd>
            @endif

            @if (isset($resource['_source']['publisher']))
                <dt>{{ trans('resource.publisher') }}</dt>
                <dd>
                    <ul>
                        @foreach($resource['_source']['publisher'] as $publisher)
                            <li>{{ $publisher['name'] }} [{{ $publisher['type']}}]</li>
                        @endforeach
                    </ul>
                </dd>
            @endif

            @if (isset($resource['_source']['issued']))
                <dt>{{ trans('resource.issued') }}</dt>
                <dd>{{ $resource['_source']['issued'] }}</dd>
            @endif

            @if (isset($resource['_source']['contributor']))
                <dt>{{ trans('resource.contributor') }}</dt>
                <dd>
                    <ul>
                        @foreach($resource['_source']['contributor'] as $contributor)
                            <li>{{ $contributor['name'] }} [{{ $contributor['type']}}]</li>
                        @endforeach
                    </ul>
                </dd>
            @endif
        </dl>

        <h4>{{ trans('resource.license') }}</h4>

    </div>
    <!-- resource context -->
    <div class="col-md-4 resource-context">

        <h4>{{ trans('resource.part_of') }}</h4>


        @if (sizeof($geo_items)>0)

            <h4>{{ trans('resource.geo_similar') }}</h4>

            <div id="map"></div>

            <script>

                var map = L.map("map").setView([0, 17], 0);

                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.Icon.Default.imagePath = '/img/leaflet';
                var resourceLocations = {!! json_encode($geo_items) !!}

                for (var i = 0; i<resourceLocations.length; i++) {
                    var latLng = [resourceLocations[i].lat,
                        resourceLocations[i].lon]

                    L.marker(latLng).addTo(map)
                }

            </script>
        @endif



        <h4>{{ trans('resource.theme_similar') }}</h4>

        <h4>{{ trans('resource.applicable_services') }}</h4>
    </div>

</div>

@endsection