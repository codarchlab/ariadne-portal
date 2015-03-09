@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $resource->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ date("d-m-Y", strtotime($resource->cr_tstamp)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $resource->id }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                        @if (isset($resource->properties['keyword']) || isset($resource->properties['subject']) || isset($resource->properties['ariadne-subject']))                        
                        <li><a href="#tab_subjects" data-toggle="tab">Subjects</a></li>
                        @endif
                        @if (isset($resource->properties['accessPolicy']) || isset($resource->properties['accessRights']) || isset($resource->properties['rights']))      
                        <li><a href="#tab_rights" data-toggle="tab">Rights</a></li>
                        @endif
                        @if (isset($resource->properties['creator']) || isset($resource->properties['owner']) || isset($resource->properties['publisher']) ||
                        isset($resource->properties['legalResponsible']) || isset($resource->properties['scientificResponsible']) || isset($resource->properties['technicalResponsible']))                          
                        <li><a href="#tab_ownership" data-toggle="tab">Ownership</a></li>
                        @endif
                        @if (isset($resource->properties['temporal']))
                        <li><a href="#tab_temporal" data-toggle="tab">Temporal</a></li>.
                        @endif
                        @if (count($resource->spatial) != 0)                       
                        <li><a href="#tab_spatial" data-toggle="tab">Spatial</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $resource->id }}</p>
                                </div>

                                @if (isset($resource->properties['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    @foreach($resource->properties['originalId'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (!empty($resource->name))
                                <div class="col-md-12">
                                    <b>Title</b>
                                    <p>{{ $resource->name }}</p>
                                </div>
                                @endif

                                @if (isset($resource->properties['description']))
                                <div class="col-md-12">
                                    <b>Description</b>
                                    @foreach($resource->properties['description'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (!empty($resource->agent_name))
                                <div class="col-md-12">
                                    <b>Agent</b>
                                    <p>{{ $resource->agent_name }}</p>
                                </div>
                                @endif

                                @if (isset($resource->properties['issued']))
                                <div class="col-md-12">
                                    <b>Issued</b>
                                    @foreach($resource->properties['issued'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['modified']))
                                <div class="col-md-12">
                                    <b>Modified</b>
                                    @foreach($resource->properties['modified'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['language']))
                                <div class="col-md-12">
                                    <b>Language</b>
                                    @foreach($resource->properties['language'] as $value)
                                    <p>{{ $value }} <img src='../img/language/{{ $value }}.png' style='height: 24px;'/></p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['extent']))
                                <div class="col-md-12">
                                    <b>Extent</b>
                                    @foreach($resource->properties['extent'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['accrualPeriodicity']))
                                <div class="col-md-12">
                                    <b>Accrual Periodicity</b>
                                    @foreach($resource->properties['accrualPeriodicity'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['landingPage']))
                                <div class="col-md-12">
                                    <b>URL</b>
                                    @foreach($resource->properties['landingPage'] as $value)
                                    <p><a href="{{ $value }}">{{ $value }}</a></p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['audience']))
                                <div class="col-md-12">
                                    <b>Audience</b>
                                    @foreach($resource->properties['audience'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>

                        @if (isset($resource->properties['keyword']) || isset($resource->properties['subject']) || isset($resource->properties['ariadne-subject']))  

                        <div class="tab-pane" id="tab_subjects">
                            <div class="row" style="padding: 14px;">

                                @if (isset($resource->properties['ariadne_subject']))
                                <div class="col-md-12">
                                    <b>Ariadne Subject</b>
                                    @foreach($resource->properties['ariadne_subject'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['subject']))
                                <div class="col-md-12">
                                    <b>Other subject</b>
                                    @foreach($resource->properties['subject'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['keyword']))
                                <div class="col-md-12">
                                    <b>Keywords</b>
                                    @foreach($resource->properties['keyword'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>                                

                        @endif

                        @if (isset($resource->properties['accessPolicy']) || isset($resource->properties['accessRights']) || isset($resource->properties['rights']))      

                        <div class="tab-pane" id="tab_rights">
                            <div class="row" style="padding: 14px;">
                                @if (isset($resource->properties['accessPolicy']))
                                <div class="col-md-12">
                                    <b>Access Policy</b>
                                    @foreach($resource->properties['accessPolicy'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['accessRights']))
                                <div class="col-md-12">
                                    <b>Access Rights</b>
                                    @foreach($resource->properties['accessRights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource->properties['rights'])) 
                                <div class="col-md-12">
                                    <b>Other rights</b>
                                    @foreach($resource->properties['rights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                

                            </div>
                        </div>

                        @endif

                        @if (isset($resource->properties['creator']) || isset($resource->properties['owner']) || isset($resource->properties['publisher']) ||
                        isset($resource->properties['legalResponsible']) || isset($resource->properties['scientificResponsible']) || isset($resource->properties['technicalResponsible']))           

                        <div class="tab-pane" id="tab_ownership">
                            <div class="row" style="padding: 14px;">

                                @if (isset($resource->properties['creator'])) 
                                <div class="col-md-12">
                                    <b>Creator</b>
                                    @foreach($resource->properties['creator'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($resource->properties['owner'])) 
                                <div class="col-md-12">
                                    <b>Owner</b>
                                    @foreach($resource->properties['owner'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($resource->properties['publisher'])) 
                                <div class="col-md-12">
                                    <b>Publisher</b>
                                    @foreach($resource->properties['publisher'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif      

                                @if (isset($resource->properties['legalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Legal Responsible</b>
                                    @foreach($resource->properties['legalResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                    

                                @if (isset($resource->properties['scientificResponsible'])) 
                                <div class="col-md-12">
                                    <b>Scientific Responsible</b>
                                    @foreach($resource->properties['scientificResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif  

                                @if (isset($resource->properties['technicalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Technical Responsible</b>
                                    @foreach($resource->properties['technicalResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif      

                            </div>
                        </div>

                        @endif

                        @if (isset($resource->properties['temporal']))

                        <div class="tab-pane" id="tab_temporal">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">

                                    @foreach ($resource->properties['temporal'] as $temporal)

                                    @if (!empty($temporal->period_name))                                            
                                    <div class='row' style='margin-bottom:8px;'>
                                        <div class='col-md-2'>
                                            <b>Period Name</b>
                                        </div>
                                        <div class='col-md-10'>
                                            <p> {{  $temporal->period_name }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <div class='row' style='margin-bottom:8px;'>
                                        <div class='col-md-4'>From Period:</div>
                                    </div>
                                    <div class='row' style='margin-bottom:8px;'>

                                        @if (!empty($temporal->from_bc))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Period:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->from_bc }}</div>
                                        @endif

                                        @if (!empty($temporal->from_year))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Year:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->from_year }}</div>
                                        @endif                                                

                                        @if (!empty($temporal->from_month))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Month:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->from_month }}</div>
                                        @endif  

                                        @if (!empty($temporal->from_day))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Day:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->from_day }}</div>
                                        @endif

                                    </div>

                                    <div class='row' style='margin-bottom:8px;'>
                                        <div class='col-md-4'>To Period:</div>                                                    
                                    </div>
                                    <div class='row' style='margin-bottom:8px;'>

                                        @if (!empty($temporal->to_bc))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Period:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->to_bc }}</div>
                                        @endif

                                        @if (!empty($temporal->to_year))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Year:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->to_year }}</div>
                                        @endif

                                        @if (!empty($temporal->to_month))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Month:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->to_month }}</div>
                                        @endif  

                                        @if (!empty($temporal->to_day))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Day:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal->to_day }}</div>
                                        @endif                                                

                                    </div>  
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @endif

                        @if (count($resource->spatial) != 0)
                        <div class="tab-pane" id="tab_spatial">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-4">

                                    @foreach($resource->spatial as $spatial)

                                    @if (!empty($spatial->placename)) 
                                    <div class="col-md-12">
                                        <b>Place Name</b>
                                        <p>{{ $spatial->placename }}</p>
                                    </div>
                                    @endif    

                                    @if (!empty($spatial->geonameid)) 
                                    <div class="col-md-12">
                                        <b>Geoname Id</b>
                                        <p>{{ $spatial->geonameid }}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial->lat)) 
                                    <div class="col-md-12">
                                        <b>Latitude</b>
                                        <p>{{ $spatial->lat }}</p>
                                    </div>
                                    @endif  

                                    @if (!empty($spatial->lon)) 
                                    <div class="col-md-12">
                                        <b>Longtitude</b>
                                        <p>{{ $spatial->lon }}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial->coordinate_system)) 
                                    <div class="col-md-12">
                                        <b>Coordinate System</b>
                                        <p>{{ $spatial->coordinate_system }}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial->address)) 
                                    <div class="col-md-12">
                                        <b>Address</b>
                                        <p>{{ $spatial->address }} {{ $spatial->numinroad}}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial->country)) 
                                    <div class="col-md-12">
                                        <b>Country</b>
                                        <p>{{ $spatial->country }}</p>
                                    </div>
                                    @endif                                             

                                    @if (!empty($spatial->postcode)) 
                                    <div class="col-md-12">
                                        <b>Postcode</b>
                                        <p>{{ $spatial->postcode }}</p>
                                    </div>
                                    @endif                                                                                              		

                                    @endforeach		
                                </div>
                                <div class="col-md-8">
                                    <div id="map-canvas" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

@if (count($resource->spatial) != 0)

    <script type="text/javascript">
        $(document).ready(function () {
            $("#map-canvas img").css("max-width", "none");
            /* GOOGLE MAP */
            function map_initialize() {
                var bounds = new google.maps.LatLngBounds();
                var myLatlng = new google.maps.LatLng({{ $resource->spatial[0]->lat }},{{ $resource->spatial[0]->lon }});

                var mapOptions = {
                    zoom: 10,
                    center: myLatlng
                }

                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var mc = new MarkerClusterer(map);

                var circlePin = {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillColor: 'red',
                    fillOpacity: .8,
                    scale: 5.5,
                    strokeColor: 'white',
                    strokeWeight: 1
                };

                var ibArray = new Array();
                var markers = [];

                @foreach($resource->spatial as $spatial)

                    var myLatlng = new google.maps.LatLng({{ $spatial->lat }}, {{ $spatial->lon }});

                    var contentString = '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h4 id="firstHeading" class="firstHeading">{{ $spatial->placename }}</h4>' +
                            '<div id="bodyContent">' +
                            // '<p>'+object.desc+'</p>'+
                            '</div>' +
                            '</div>';


                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    //ibArray[idx] = infowindow;

                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '{{ $spatial->placename }}',
                        icon: circlePin
                    });
                    //bounds.extend(marker.position);

                    google.maps.event.addListener(marker, 'click', function () {

                        for (var i = 0; i < ibArray.length; i++) {
                            ibArray[i].close();
                        }

                        infowindow.open(map, marker);
                    });

                    markers.push(marker);
                    //});

                @endforeach

                var mc = new MarkerClusterer(map, markers);
                /*$.ajax({
                 type: "POST",
                 url: "components/map/rest_get_markers.php",
                 dataType: 'json',
                 success: function(data) {
                 //console.log(data.markers);
                 $.each(data.markers,function(idx,object){ 
                 var myLatlng = new google.maps.LatLng(parseFloat(object.lat),parseFloat(object.lon));

                 var contentString =   '<div id="content">'+
                 '<div id="siteNotice">'+
                 '</div>'+
                 '<h4 id="firstHeading" class="firstHeading">'+object.label+'</h4>'+
                 '<div id="bodyContent">'+
                 '<p>'+object.desc+'</p>'+
                 '</div>'+
                 '</div>';


                 var infowindow = new google.maps.InfoWindow({
                 content: contentString
                 });

                 ibArray[idx] = infowindow;

                 var marker = new google.maps.Marker({
                 position: myLatlng,
                 map: map,
                 title: object.label,
                 icon: circlePin
                 });
                 //bounds.extend(marker.position);

                 google.maps.event.addListener(marker, 'click', function() {

                 for (var i = 0; i < ibArray.length; i++ ) {
                 ibArray[i].close();
                 }

                 infowindow.open(map,marker);
                 });

                 markers.push(marker);
                 });
                 var mc = new MarkerClusterer(map, markers);

                 },
                 error: function(ret) { alert("There was an error when retrieving the enrichment details."); }
                 });*/


                /*
                 google.maps.event.addListener(map, 'zoom_changed', function() {
                 zoomChangeBoundsListener = 
                 google.maps.event.addListener(map, 'bounds_changed', function(event) {
                 if (this.getZoom() > 15 && this.initialZoom == true) {
                 // Change max/min zoom here
                 this.setZoom(15);
                 this.initialZoom = false;
                 }
                 google.maps.event.removeListener(zoomChangeBoundsListener);
                 });
                 });

                 map.initialZoom = true;
                 map.fitBounds(bounds);
                 */
                $(document).on('click', '.nav-tabs li', function (event) {
                    google.maps.event.trigger(map, 'resize');
                });

            }

            function zoomTo(level) {
                google.maps.event.addListener(map, 'zoom_changed', function () {
                    zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function (event) {
                        if (this.getZoom() > level && this.initialZoom == true) {
                            this.setZoom(level);
                            this.initialZoom = false;
                        }
                        google.maps.event.removeListener(zoomChangeBoundsListener);
                    });
                });
            }

            map_initialize();

        });
    </script>

@endif

@endsection