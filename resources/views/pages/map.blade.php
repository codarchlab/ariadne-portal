@extends('app')

@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" >
                    <div class="box-body" id='map' style="width:100%; height:700px; margin: 0px; padding: 0px; z-index: 1001;">
                                
                    </div> <!-- /.box-body -->
                </div>
            </div><!-- /.col -->           
        </div>
    </section><!-- /.content -->                
</aside><!-- /.right-side -->
 <script>       
        jQuery(document).ready(function() {
            var posLatitude = $('#map').data('position-latitude'),
                posLongitude = $('#map').data('position-longitude');

            function map_initialize() {
                var myLatlng = new google.maps.LatLng(posLatitude,posLongitude);

                var mapOptions = {
                        zoom: 4,
                        center: myLatlng
                }

                var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                var mc = new MarkerClusterer(map);

                 var circlePin = {
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: 'red',
                        fillOpacity: .8,
                        scale: 5.5,
                        strokeColor: 'white',
                        strokeWeight: 1
                };

                var markers = [];
                <?php 
                foreach ($points as &$point) {
                    foreach ($point['_source']['spatial'] as &$spatial) {
                        //$placename = $point['_source']['spatial'][0]['placeName'];    
                        $placename = str_replace(array("\r", "\n", "\t", "\v"), '', $spatial['placeName']); 
                        $lon 	= $spatial['location']['lat'];      
                        $lat 	= $spatial['location']['lon'];                       
                ?>		

                var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>);

                var contentString =   '<div>'+
                                        '<div id="siteNotice">'+
                                        '</div>'+
                                        '<h4 id="firstHeading" class="firstHeading"><?php echo $placename; ?></h4>'+
                                        '<div id="bodyContent">'+
                                        '</div>'+
                                        '</div>';


                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '<?php echo $placename; ?>',
                        icon: circlePin,
                        html: contentString

                });

                markers.push(marker);

                    <?php } }?>

                for (var i = 0; i < markers.length; i++) {
                    var marker = markers[i];
                    google.maps.event.addListener(marker, 'click', function () {
                        // where I have added .html to the marker object.
                        infowindow.setContent(this.html);
                        infowindow.open(map, this);
                    });
                }

                function AutoCenter() {
                    if (markers.length>1){
                        //  Create a new viewpoint bound
                        var bounds = new google.maps.LatLngBounds();
                        //  Go through each...
                        $.each(markers, function (index, marker) {
                            bounds.extend(marker.position);
                        });
                        //  Fit these bounds to the map
                        map.fitBounds(bounds);
                    }
                    else{
                        map.setCenter(marker.position);
                    }
                }

                var mc = new MarkerClusterer(map, markers);	

                
                google.maps.event.trigger(map, 'resize');
                AutoCenter();
               

            }
            map_initialize();


        });
    </script>    
@endsection