@extends('app')
@section('title', $resource['_source']['title'].' - Ariadne portal')

@if (isset($resource['_source']['description']))

    <?php
        $description = strip_tags($resource['_source']['description']);
        $length = 155;

        if (strlen($description) > $length) {

            $description = substr($description, 0, $length) . '...';
        }
    ?>

    @section('description', $description)

@endif

@if (isset($resource['_source']['nativeSubject']))

    <?php $keywords = array(); ?>

    @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
        <?php $keywords[] = $nativeSubject['prefLabel']; ?>
    @endforeach

    <?php $keywords = implode(',', $keywords); ?>

    @section('keywords', $keywords)

@endif

@section('content')

<div id="citationModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('resource.cite.header') }}</h4>
            </div>
            <div class="modal-body resource-citation-modal">
                <div class="info">{{ trans('resource.cite.info') }}.</div>
                <form>
                    <input id="citationLink" type="text" readonly value="{{$citationLink}}"></input>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#citationModal').on('shown.bs.modal', function() {
            $('#citationLink').select();
        });
    </script>
</div>

<div class="row">

    <!-- resoure metadata -->
    <div class="col-md-8 resource-metadata" itemscope itemtype="http://schema.org/Dataset">
        <h3 itemprop="name">{{ $resource['_source']['title'] }}</h3>

        <div>
            @if (isset($resource['_source']['landingPage']))
                <a href="{{ $resource['_source']['landingPage']}}" target="_blank" itemprop="sameAs">
                    <span class="glyphicon glyphicon-globe"></span> {{ trans('resource.landing_page') }}
                </a>
            @endif

            <!-- TODO Add contact information when available in data. See mockups. -->

            <div class="pull-right">
                <!-- TODO Enable button when endpoint for export is available. -->
                <a class="button">
                    <span class="glyphicon glyphicon-file"></span>
                </a>
                <a class="button" data-toggle="modal" data-target="#citationModal">
                    <span class="glyphicon glyphicon-link"></span>
                </a>
            </div>
        </div>

        @if (isset($resource['_source']['description']))
            <div id="description" itemprop="description">
                {!! $resource['_source']['description'] !!}
            </div>
        @endif

        @if (isset($resource['_source']['nativeSubject']))
            <div>
                @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
                    <a class="tag" href="{{ route('search', [ 'nativeSubject' => $nativeSubject['prefLabel'] ]) }}">
                        <span class="glyphicon glyphicon-tag"></span>
                        <span itemprop="keywords">{{ $nativeSubject['prefLabel'] }}</span>
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
                            <span itemprop="spatial" itemscope="itemscope" itemtype="http://schema.org/Place" itemid="http://dbpedia.org/resource/{{ $spatial['placeName'] }}">{{ $spatial['placeName'] }}</span>
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

            @if (isset($resource['_source']['language']))
                <dt>{{ trans('resource.language') }}</dt>
                <dd itemprop="inLanguage">{{ trans('resource.language.'.$resource['_source']['language']) }}</dd>
            @endif

            @if (isset($resource['_source']['archaeologicalResourceType']))
                <dt>{{ trans('resource.archaeologicalResourceType') }}</dt>
                <dd>{{ $resource['_source']['archaeologicalResourceType']['name'] }}</dd>
            @endif

            @if (isset($resource['_source']['resourceType']))
                <dt>{{ trans('resource.resourceType') }}</dt>
                <dd>{{ trans('resource.resourceType.'.$resource['_source']['resourceType']) }}</dd>
            @endif

            @if (isset($resource['_source']['publisher']))
                <dt>{{ trans('resource.publisher') }}</dt>
                <dd>
                    <ul>
                        @foreach($resource['_source']['publisher'] as $publisher)
                            <li itemprop="publisher" itemscope="" itemtype="http://schema.org/ {{ $publisher['type'] }}">{{ $publisher['name'] }} [{{ $publisher['type']}}]</li>
                        @endforeach
                    </ul>
                </dd>
            @endif

            @if (isset($resource['_source']['issued']))
                <dt>{{ trans('resource.issued') }}</dt>
                <dd itemprop="datePublished">{{ $resource['_source']['issued'] }}</dd>
            @endif

            @if (isset($resource['_source']['contributor']))
                <dt>{{ trans('resource.contributor') }}</dt>
                <dd>
                    <ul>
                        @foreach($resource['_source']['contributor'] as $contributor)
                        <li itemprop="contributor" itemscope="" itemtype="http://schema.org/ {{ $contributor['type'] }}"><span itemprop="name">{{ $contributor['name'] }}</span> [{{ $contributor['type']}}]</li>
                        @endforeach
                    </ul>
                </dd>
            @endif
        </dl>

        <h4>{{ trans('resource.license') }}</h4>
        
        <dl class="dl-horizontal">

            @if (isset($resource['_source']['accessRights']))
                <dt>{{ trans('resource.accessRights') }}</dt>
                <dd>{{ $resource['_source']['accessRights'] }}</dd>
            @endif
            
            @if (isset($resource['_source']['accessPolicy']))
                <dt>{{ trans('resource.accessPolicy') }}</dt>
                <dd>
                    @if(filter_var($resource['_source']['accessPolicy'], FILTER_VALIDATE_URL))
                    <a href="{{ $resource['_source']['accessPolicy'] }}">
                        {{ $resource['_source']['accessPolicy'] }}
                    </a>
                    @else
                    {{ $resource['_source']['accessPolicy'] }}
                    @endif
                </dd>
            @endif

        </dl>

    </div>
    <!-- resource context -->
    <div class="col-md-4 resource-context">

        @if (isset($resource['_source']['isPartOf']))
            <h4>{{ trans('resource.part_of') }}</h4>           
            @foreach($resource['_source']['isPartOf'] as $isPartOf)
                <p>{{ $isPartOf }}</p>
            @endforeach
        @endif
        
        @if (isset($parts_count) && $parts_count != 0)
            <h4>{{ trans('resource.has_parts') }}</h4>  
            <p>
                <a href="{{ route('search', [ 'q' => 'isPartOf:' . $resource['_id'] ]) }}">
                    {{ trans('resource.children') .' (' . $parts_count . ')' }}
                </a>
            </p>
        @endif
        
        @if (sizeof($geo_items)>0)

            <h4>{{ trans('resource.geo_similar') }}</h4>

            <div id="map"></div>

            <script>
                $("#description").readmore({
                    moreLink: '<a href="#"><?php print trans('resource.readmore'); ?></a>',
                    lessLink: '<a href="#"><?php print trans('resource.readless'); ?></a>'
                });
                
                var initializeMap = function() {
                    var map = L.map("map");
                    map.setView([0, 17], 0);

                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    L.Icon.Default.imagePath = '/img/leaflet/default';

                    return map;
                };

                var markerIconForColor = function(markerColor) {

                    var markerFilePath = '/img/leaflet/default/marker-icon.png';
                    if (markerColor)
                        markerFilePath = '/img/leaflet/custom/marker-icon-' + markerColor + '.png';

                    var markerIcon = L.icon({
                            iconUrl: markerFilePath,
                            iconSize: [25, 41],
                            iconAnchor: [12, 40],
                            shadowUrl: '/img/leaflet/default/marker-shadow.png',
                            shadowSize: [41, 41],
                            shadowAnchor: [12, 40]
                        });

                    return markerIcon;
                };

                var markerClickFunction = function(e) {
                    window.location = '/search?spatial='+ e.target.label._content;
                };

                var markerOptions = function(priority,markerColor) {
                    var markerOptions = { icon: markerIconForColor(markerColor), riseOnHover: true};
                    if (priority)
                        markerOptions.zIndexOffset = 1000;
                    return markerOptions;
                };

                var labelOptions = function() {
                    return {
                        offset: [30,0],
                        className: "marker-label"
                    }
                };

                var makeMarker = function(spatialItem,priority,markerColor) {
                    var marker = L.marker([spatialItem.location.lat, spatialItem.location.lon],
                        markerOptions(priority,markerColor));
                    marker.bindLabel(spatialItem.placeName,  labelOptions());
                    marker.on('click',markerClickFunction);
                    return marker;
                };

                var createMarkers = function(spatialItems, priority, markerColor) {
                    var markers = [];

                    for (var i = 0; i<spatialItems.length; i++)
                        markers.push(makeMarker(spatialItems[i],priority,markerColor));

                    return markers;
                };

                var showMarkers = function(map,markers) {
                    for (var i in markers) {
                        markers[i].addTo(map);
                    }
                };

                var fitViewportToMarkers = function(map,markers) {
                    var group = L.featureGroup(markers);
                    map.fitBounds(group.getBounds());
                };


                // Main

                var spatialItems = {!! json_encode($geo_items) !!}
                var nearbySpatialItems = {!! json_encode($nearby_geo_items) !!}

                var markers = [];
                markers = markers.concat(createMarkers(nearbySpatialItems, false));
                markers = markers.concat(createMarkers(spatialItems, true, 'orange'));

                var map = initializeMap();
                showMarkers(map,markers);
                fitViewportToMarkers(map,markers);

            </script>
        @endif



        <h4>{{ trans('resource.theme_similar') }}</h4>
        <ul>
        @foreach($similar_resources as $similar_resource)
            <li>
                <a href="{{ route('resource.page', [ $similar_resource['_id'] ]  ) }}">
                    {{ $similar_resource['_source']['title'] }}
                </a>
            </li>
        @endforeach
        </ul>

        <h4>{{ trans('resource.applicable_services') }}</h4>
    </div>

</div>

@endsection