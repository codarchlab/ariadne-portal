@extends('app')

@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" >
                    <div class="box-body" id='map' style="width:100%; height:500px; margin: 0px; padding: 0px; z-index: 1001;">                              
                    </div> <!-- /.box-body -->
                    <form>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                    </form>
                </div>
            </div><!-- /.col -->           
        </div>
       <!-- <div class="row">
            <div class="col-md-12">
                <p>                    
                    <a href="#" id='clear_map' class="btn btn-sm btn-primary"></a>
                </p> 
            </div>
        </div>	-->
        <div class="row" id="results">            
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
                        if (isset($spatial['placeName'])) {
                            //$placename = $point['_source']['spatial'][0]['placeName'];    
                            $placename = str_replace(array("\r", "\n", "\t", "\v"), '', $spatial['placeName']); 
                            //lat lon must be changed in data
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

                <?php } } }?>

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
               
                var drawingManager = new google.maps.drawing.DrawingManager({
                     drawingMode: google.maps.drawing.OverlayType.RECTANGLE,
                     drawingControl: true,
                     drawingControlOptions: {
                         position: google.maps.ControlPosition.TOP_CENTER,
                         drawingModes: [
                           google.maps.drawing.OverlayType.RECTANGLE
                         ]
                     },
                     rectangleOptions: {
                         editable:true,
                         draggable:true,
                         geodesic:true
                     }
                 });
                drawingManager.setMap(map);
                 
                /*google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                    drawingManager.setMap(null);
                    drawingManager.setDrawingMode(null);
                });*/
    
                google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {                    
                    var bounds = event.overlay.getBounds();                   
                    event.overlay.setMap(null);                  
                    //console.log(bounds);
                    var top_left_lan = bounds.getNorthEast().lat();
                    var top_left_lon = bounds.getNorthEast().lng();
                    var bottom_right_lan = bounds.getSouthWest().lat();
                    var bottom_right_lon = bounds.getSouthWest().lng();
                    console.log(top_left_lan,top_left_lon,bottom_right_lan,bottom_right_lon);
                    
                    $.ajax({
                        type: "POST",
                        headers: { 'Access-Control-Allow-Origin': '*' },
                        data: { "top_left_lan":top_left_lan,"top_left_lon":top_left_lon,"bottom_right_lan":bottom_right_lan,"bottom_right_lon":bottom_right_lon, _token: $('input[name=_token]').val()},
                        url: "map_results",
                        success: function(response) { 
                            $( "#results" ).empty();
                            console.log(response); 
                            var ObjectsNum = response.length;
                            var result_boxes = "";
                            for (var i = 0; i < ObjectsNum; i++) {
                                //alert(response[i]['_id']); 
                                if (response[i]['_source']['description']!="") var description = response[i]['_source']['description'];
                                else var description = '';
                                var url = '{{ action("CollectionController@show", ":id") }}';
                                url = url.replace(':id', response[i]['_id']);
                                if (response[i]['_type']=="dataset") url = url.replace('CollectionController@show', 'DatasetController@show');
                                if (response[i]['_type']=="database") url = url.replace('CollectionController@show', 'DatabaseController@show');
                                if (response[i]['_type']=="gis") url = url.replace('CollectionController@show', 'GisController@show');
                                if (response[i]['_type']=="textualDocument") url = url.replace('CollectionController@show', 'TextualDocumentController@show');
                                result_boxes +=  '<div class="col-md-4">'
                                                    +' <div class="box box-primary" id="dataresource_item" item_id='+response[i]['_id']+'>'
                                                        +'<div class="box-body">'
                                                            +'<div class="row">'
                                                                +'<div class="col-md-3">'
                                                                    +'<img src="img/monument.png" height="50" border="0"> '
                                                                +'</div>'
                                                                +'<div class="col-md-8">'
                                                                    +'<div class="row">'
                                                                        +'<a href="'+url+'" target="blank">'+response[i]['_source']['title']+'</a>'
                                                                        +'<p>'+description+'</p>'
                                                                    +'</div>'
                                                                +'</div>'
                                                            +'</div>'
                                                            +'<div class="row">'
                                                                +'<div class="col-md-4">'
                                                                    +'type: <span class="badge">'+response[i]['_type']+'</span>'
                                                                +'</div>'
                                                            +'</div>'
                                                        +'</div>'
                                                    +'</div>'
                                                +'</div>';                                
                            }  
                            $('#results').append(result_boxes);
                            if (ObjectsNum==0) $('#results').append('There are no items in this area');
                        }, 
                        error: function(response) {                             
                            console.log('server errors',response);
                        } 
                    });
                });

            }
            map_initialize();

            
        });
    </script>    
@endsection