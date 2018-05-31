@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-body">
                    <div class="col-lg-6  col-xs-12">
                    
                        <form id="fr-inicio" class="form-horizontal" method="POST" action="/verificar" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="form-group">
                                <label for="servicios">Servicios</label>
                                <select name="service" id="service" class="form-control">
                                
                                    <option value="0">Seleccione</option>
                                    @foreach($servicios as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                    <label for="subservicios">Sub-servicios</label>
                                    <select name="subservice" id="subservice" class="form-control">
                                        <option value="0">Seleccione</option>
                                    </select>
                            </div>

                            <div class="otro-servicio" style="display:none;">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea class="form-control" name="description">

                                    </textarea>
                                </div>
                                <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" class="form-control" name="imagen1">
                                </div>
                                <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" class="form-control" name="imagen2">
                                </div>
                                <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" class="form-control" name="imagen3">
                                </div>
                                <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" class="form-control" name="imagen4">
                                </div>
                                <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" class="form-control" name="imagen5">
                                </div>
                            </div>

                            <div class="form-group provincias" style="display:none;">
                                    <label for="provincia">provincia</label>
                                    <select name="province" id="province" class="form-control">
                                    
                                    <option value="0">Seleccione</option>
                                    @foreach($provincias as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                    </select>
                            </div>

                            <div style="overflow:hidden;" class="datatimer" >
                                    <div class="form-group">
                                        <div id="datetimepicker1"></div> 
                                    </div>
                            </div>
                            <input type="hidden" name="latitud" id="latitud">
                            <input type="hidden" name="longitud" id="longitud">
                            <input type="hidden" name="comercio_id" id="comercio_id" >
                        </form>
                </div>
                     <div class="col-md-6 col-xs-12">
                        <div id="canvas" style="height:500px">
                            mapa
                        </div>
                       
                    </div>
                </div>
                <div class="col-md-12 text-center">
                        <div class="form-group" style="margin-top:40px;">
                                <a href="#" class="btn btn-primary" id="registro-solicitud">Solictar Servicio</a>
                            
                          </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        function initMap() {
                var map = new google.maps.Map(document.getElementById('canvas'), {
                    
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 11
                       
                });
              
               

                var infoWindow = new google.maps.InfoWindow({map: map});
                

               
            
            // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                        };
            
                        infoWindow.setPosition(pos);
                        infoWindow.setContent('tu localización');
                        map.setCenter(pos);
                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
        }
    
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
            console.log('no soporta ');
            $(".provincias").show();
        }
        var e = document.getElementById("province");
    document.getElementById("province").addEventListener('change',function(){
        var provincia = e.options[e.selectedIndex].value;
       
        $.ajax({
            url:'/getmarker/'+provincia,
            type:'GET',
            dataType:'json',
            success:function(response){
                puntos(response);
               // marcadores(response.marker);
            }
        });
        
    });
  
function puntos(provincia){

    var map = new google.maps.Map(document.getElementById('canvas'), mapOptions);
                var bounds = new google.maps.LatLngBounds();
                var mapOptions = {
                    mapTypeId: 'roadmap'                    
                };
    

    var infoWindow = new google.maps.InfoWindow(), marker, i;

    var markers = marcadores(provincia);
    var infoWindowContent = contenidos(provincia);
    
   console.log("longitud "+markers.length);  

    for( i = 0; i < markers.length; i++ ) {
        console.log(i+" - "+markers[i]['lat']);

            var position = new google.maps.LatLng(markers[i]['lat'], markers[i]['lng']);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i]['name']
            });
            
            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i]['name']);
                    infoWindow.open(map, marker);
                    $("#comercio_id").val(infoWindowContent[i]['id']);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
}

function marcadores(valor){
    var ic="";
    var len = valor.marker.length;
    var j=1;
   
     // Multiple Markers
     var markers = valor.marker;
    
    return markers;
}
function contenidos(valor){
     // Info Window Content
     
     var infoWindowContent =  valor.marker;
       
    return infoWindowContent;
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn9eQmmhf88EIDadcj0XpL55E-9PziPME&callback=initMap"
    async defer></script>
@endsection