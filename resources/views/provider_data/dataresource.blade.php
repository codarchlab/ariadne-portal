@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $resource['_source']['title'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $resource['_id'] }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                        @if (isset($resource['_source']['keyword']) || isset($resource['_source']['nativeSubject']) || isset($resource['_source']['archaeologicalResourceType']))                        
                        <li><a href="#tab_subjects" data-toggle="tab">Subjects</a></li>
                        @endif
                        @if (isset($resource['_source']['rights']))      
                        <li><a href="#tab_rights" data-toggle="tab">Rights</a></li>
                        @endif
                        @if (isset($resource['_source']['creator']) || isset($resource['_source']['publisher']) || isset($resource['_source']['contributor']))                          
                        <li><a href="#tab_ownership" data-toggle="tab">Ownership</a></li>
                        @endif
                        @if (isset($resource['_source']['temporal']))
                        <li><a href="#tab_temporal" data-toggle="tab">Temporal</a></li>
                        @endif
                        @if (isset($resource['_source']['spatial']))                       
                        <li><a href="#tab_spatial" data-toggle="tab">Spatial</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $resource['_id'] }}</p>
                                </div>

                                @if (isset($resource['_source']['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    <p>{{ $resource['_source']['originalId'] }}</p>
                                </div>
                                @endif
                                
                                @if (isset($resource['_source']['identifier']))
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p><a href='#'>{{ $resource['_source']['identifier'] }}</a></p>
                                </div>
                                @endif

                                @if (!empty($resource['_source']['title']))
                                <div class="col-md-12">
                                    <b>Title</b>
                                    <p>{{ $resource['_source']['title'] }}</p>
                                </div>
                                @endif

                                @if (isset($resource['_source']['description']))
                                <div class="col-md-12">
                                    <b>Description</b>
                                    <p>{{ $resource['_source']['description'] }}</p>
                                </div>
                                @endif


                                @if (isset($resource['_source']['issued']))
                                <div class="col-md-12">
                                    <b>Issued</b>
                                    <p>{{ $resource['_source']['issued'] }}</p>
                                </div>
                                @endif


                                @if (isset($resource['_source']['language']))
                                <div class="col-md-12">
                                    <b>Language</b>
                                    <p>{{ $resource['_source']['language'] }} <img src='../img/language/{{ $resource['_source']['language'] }}.png' style='height: 24px;'/></p>
                                </div>
                                @endif


                                @if (isset($resource['_source']['landingPage']))
                                <div class="col-md-12">
                                    <b>URL</b>
                                    <p><a href="{{ $resource['_source']['landingPage'] }}">{{ $resource['_source']['landingPage'] }}</a></p>
                                </div>
                                @endif

                                @if (isset($resource['_source']['audience']))
                                <div class="col-md-12">
                                    <b>Audience</b>
                                    <p>{{ $resource['_source']['audience'] }}</p>
                                </div>
                                @endif

                            </div>
                        </div>

                        @if (isset($resource['_source']['keyword']) || isset($resource['_source']['nativeSubject']) || isset($resource['_source']['archaeologicalResourceType']))  

                        <div class="tab-pane" id="tab_subjects">
                            <div class="row" style="padding: 14px;">

                                @if (isset($resource['_source']['archaeologicalResourceType']))
                                <div class="col-md-12">
                                    <b>Archaeological Resource Type</b>
                                   
                                        <p>{{$resource['_source']['archaeologicalResourceType']['name']}}</p>
                                   
                                </div>
                                @endif

                                @if (isset($resource['_source']['nativeSubject']))
                                <div class="col-md-12">
                                    <b>Native subject</b><br/>
                                     <ol>
                                    @foreach($resource['_source']['nativeSubject'] as $value)                                       
                                        <li>
                                            <b>Label</b><p>{{ $value['prefLabel'] }}</p>
                                            <b>Concept URI</b><p><a href='{{ $value['rdfAbout'] }}' target="blank">{{ $value['rdfAbout'] }}</a></p>
                                        </li>                                       
                                    @endforeach
                                     </ol>
                                </div>
                                @endif

                                @if (isset($resource['_source']['keyword']))
                                <div class="col-md-12">
                                    <b>Keywords</b>
                                    @foreach($resource['_source']['keyword'] as $value)
                                    <p><a href="{{ route('search', ['keyword' => $value]) }}">{{ $value }}</a></p>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>                                

                        @endif

                        @if (isset($resource['_source']['accessPolicy']) || isset($resource['_source']['accessRights']) || isset($resource['_source']['rights']))      

                        <div class="tab-pane" id="tab_rights">
                            <div class="row" style="padding: 14px;">
                                @if (isset($resource['_source']['accessPolicy']))
                                <div class="col-md-12">
                                    <b>Access Policy</b>
                                    @foreach($resource['_source']['accessPolicy'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource['_source']['accessRights']))
                                <div class="col-md-12">
                                    <b>Access Rights</b>
                                    @foreach($resource['_source']['accessRights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($resource['_source']['rights'])) 
                                <div class="col-md-12">
                                    <b>Other rights</b>
                                    @foreach($resource['_source']['rights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                

                            </div>
                        </div>

                        @endif

                        @if (isset($resource['_source']['creator']) || isset($resource['_source']['contributor']) || isset($resource['_source']['owner']) || isset($resource['_source']['publisher']) ||
                        isset($resource['_source']['legalResponsible']) || isset($resource['_source']['scientificResponsible']) || isset($resource['_source']['technicalResponsible']))           

                        <div class="tab-pane" id="tab_ownership">
                            <div class="row" style="padding: 14px;">

                                @if (isset($resource['_source']['creator'])) 
                                <div class="col-md-12">
                                    <b>Creator</b>
                                    @foreach($resource['_source']['creator'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($resource['_source']['owner'])) 
                                <div class="col-md-12">
                                    <b>Owner</b>
                                    @foreach($resource['_source']['owner'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif  
                                
                                @if (isset($resource['_source']['contributor'])) 
                                <div class="col-md-12">
                                    <b>Contributor</b>
                                    @foreach($resource['_source']['contributor'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($resource['_source']['publisher'])) 
                                <div class="col-md-12">
                                    <b>Publisher</b>
                                    @foreach($resource['_source']['publisher'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif      

                                @if (isset($resource['_source']['legalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Legal Responsible</b>
                                    @foreach($resource['_source']['legalResponsible'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif                                    

                                @if (isset($resource['_source']['scientificResponsible'])) 
                                <div class="col-md-12">
                                    <b>Scientific Responsible</b>
                                    @foreach($resource['_source']['scientificResponsible'] as $value)
                                    <p>{{ $value['name'] }}</p>
                                    @endforeach
                                </div>
                                @endif  

                                @if (isset($resource['_source']['technicalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Technical Responsible</b>
                                    @foreach($resource['_source']['technicalResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif      

                            </div>
                        </div>

                        @endif

                        @if (isset($resource['_source']['temporal']))

                        <div class="tab-pane" id="tab_temporal">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">

                                    @foreach ($resource['_source']['temporal'] as $temporal)

                                    @if (!empty($temporal['periodName']))                                            
                                    <div class='row' style='margin-bottom:8px;'>
                                        <div class='col-md-2'>
                                            <b>Period Name</b>
                                        </div>
                                        <div class='col-md-10'>
                                            <p> {{  $temporal['periodName'] }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <div class='row' style='margin-bottom:8px;'>
                                        <div class='col-md-4'>From Period:</div>
                                    </div>
                                    <div class='row' style='margin-bottom:8px;'>

                                        @if (!empty($temporal['from']))
                                        <div class='col-md-2 col-sm-offset-2'>
                                            <b>Period:</b>
                                        </div>
                                        <div class='col-md-8'>{{ $temporal['from'] }}</div>
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

                        @if (isset($resource['_source']['spatial']))
                        <div class="tab-pane" id="tab_spatial">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-4">

                                    @foreach($resource['_source']['spatial'] as $spatial)

                                    @if (!empty($spatial['placeName'])) 
                                    <div class="col-md-12">
                                        <b>Place Name</b>
                                        <p>{{ $spatial['placeName'] }}</p>
                                    </div>
                                    @endif    


                                    @if (!empty($spatial['location']['lat'])) 
                                    <div class="col-md-12">
                                        <b>Latitude</b>
                                        <p>{{ $spatial['location']['lat'] }}</p>
                                    </div>
                                    @endif  

                                    @if (!empty($spatial['location']['lon'])) 
                                    <div class="col-md-12">
                                        <b>Longtitude</b>
                                        <p>{{ $spatial['location']['lon'] }}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial['coordinateSystem'])) 
                                    <div class="col-md-12">
                                        <b>Coordinate System</b>
                                        <p>{{ $spatial['coordinateSystem'] }}</p>
                                    </div>
                                    @endif 

                                    @if (!empty($spatial['country'])) 
                                    <div class="col-md-12">
                                        <b>Country</b>
                                        <p>{{ $spatial['country'] }}</p>
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

@if (isset($resource['_source']['spatial']) && isset($resource['_source']['spatial'][0]['location']['lat']))

    <script type="text/javascript">
        $(document).ready(function () {
            $("#map-canvas img").css("max-width", "none");
            /* GOOGLE MAP */
            function map_initialize() {
                var bounds = new google.maps.LatLngBounds();
                var myLatlng = new google.maps.LatLng({{ $spatial['location']['lat']  }},{{ $spatial['location']['lon'] }});

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

                @foreach($resource['_source']['spatial'] as $spatial)
                    <?php $placename = str_replace(array("\r", "\n", "\t", "\v"), '', $spatial['placeName']); ?>
                    //lat lon must be changed in data
                    var myLatlng = new google.maps.LatLng({{ $spatial['location']['lat'] }}, {{ $spatial['location']['lon'] }});

                    var contentString = '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h4 id="firstHeading" class="firstHeading"><?php echo $placename; ?></h4>' +
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
                        title: '<?php echo $placename; ?>',
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