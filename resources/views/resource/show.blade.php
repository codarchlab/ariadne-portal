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
                    <!-- TODO search for subject -->
                    <a class="tag">
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

                <!-- TODO search for period -->
                    <a class="tag">
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
                        <!-- TODO search for place -->
                        <a class="tag">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $spatial['placeName'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <h4>{{ trans('resource.metadata') }}</h4>

        <h4>{{ trans('resource.license') }}</h4>


        <dl class="dl-horizontal">


            @if (isset($resource['_id']))
                <dt>{{ trans('resource.identifier') }}</dt>
                <dd>{{ $resource['_id'] }}</dd>
            @endif

            @if (isset($resource['_type']))
                <dt>{{ trans('resource.type') }}</dt>
                <dd>{{ trans('resource.type_'.$resource['_type']) }}</dd>
            @endif

            @if (isset($resource['_source']['language']))
                <dt>{{ trans('resource.language') }}</dt>
                <dd>{{ trans('resource.language_'.$resource['_source']['language']) }}</dd>
            @endif

            @if (isset($resource['_source']['archaeologicalResourceType']))
                <dt>{{ trans('resource.resource_type') }}</dt>
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



    </div>
    <!-- resource context -->
    <div class="col-md-4 resource-context">
        <h4>{{ trans('resource.part_of') }}</h4>
        <h4>{{ trans('resource.geo_similar') }}</h4>
        <div id="map"></div>
        <script>
            var map = L.map("map").setView([0, 0], 10);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        </script>
        <h4>{{ trans('resource.theme_similar') }}</h4>
        <h4>{{ trans('resource.applicable_services') }}</h4>
    </div>

</div>

@endsection