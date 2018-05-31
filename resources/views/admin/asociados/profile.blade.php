@extends('layouts.master')

@section('content')
<section class="content-header">
      <h1>PERFIL</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Perfil</li>
        </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="box">
            
                <div class="box-body">
                    <div class="panel-body">
                        <form id="fr-profile" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" name="_method" value="PUT">
                          <input type="hidden" name="admin_id" id="admin_id" value="{{ $admin_id }}">

                          <div class="modal-header">
                            
                            
                          </div>
                          <div class="modal-body">
                              
    
                              <div class="form-group">
                                <label for="title">Nombre Comercial</label>
                                <input type="text" name="tradename" class="form-control" id="tradename" value="{{ @$profile->tradename }}" placeholder="Nombre Comercial">
                              </div>
            
                              <div class="form-group">
                                  <label for="title">Contacto</label>
                                  <input type="text" name="contact" class="form-control" id="contact" value="{{ @$profile->contact }}" placeholder="Contacto">
                              </div>
            
            
                              <div class="form-group">
                                  <label for="title">Email</label>
                                  <input type="text" name="email" class="form-control" id="email" value="{{ @$profile->email }}" placeholder="Contacto">
                              </div>
                              
                              <fieldset id="telefonos">
                                  <a href="#" class="btn btn-xs btn-default addphone">Agregar telefono</a>
                                @foreach($phones as $ph) 
                                  <div class="form-group stack">
                                      <label for="telefono">Telefono</label>
                                      <input type="text" class="form-control" name="phone[]" value="{{ $ph->phone }}">
                                  </div>
                                @endforeach
                              </fieldset>
                             
                              <div class="form-group">
                                    <label for="page">Paginas</label>
                                    <input type="text" name="website" class="form-control" id="website" value="{{ @$profile->website }}" placeholder="Page web">
                              </div>
            
                              <fieldset id="photos">
                                  <a href="#" class="btn btn-xs btn-default addphoto">Agregar foto</a>
                                  
                                @if(count($photos)>0)
                                  <ul>
                                    @foreach($photos as $foto)
                                   <li> <img src="/photos/{{ $foto->name }}" alt="" width="100">
                                    <a href="#" class="delete-photo" data-id="{{ $foto->id }}"><i class="fa fa-fw fa-times-circle"></i></a>
                                   </li>
                                    @endforeach
                                  </ul>
                                @else
                                 
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file"  class="form-control" name="photo[]">
                                </div>

                                @endif

                              </fieldset>
                              
                              <fieldset id="horario">
                                <legend>Horario de atención</legend>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="page">Lunes</label>
                                      <input type="text" name="apertura[]" id="sem1" class="form-control semana"  value="{{ @$dias[0]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem2" class="form-control semana " value="{{ @$dias[0]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="lunes">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Martes</label>
                                      <input type="text" name="apertura[]" id="sem3" class="form-control semana"  value="{{ @$dias[1]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]"  id="sem4" class="form-control semana"  value="{{ @$dias[1]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="martes">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Miercoles</label>
                                      <input type="text" name="apertura[]" id="sem5" class="form-control"  value="{{ @$dias[2]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem6" class="form-control"  value="{{ @$dias[2]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="miercoles">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Jueves</label>
                                      <input type="text" name="apertura[]" id="sem7" class="form-control"  value="{{ @$dias[3]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem8" class="form-control"  value="{{ @$dias[3]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="jueves">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Viernes</label>
                                      <input type="text" name="apertura[]" id="sem9" class="form-control"  value="{{ @$dias[4]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem10" class="form-control"  value="{{ @$dias[4]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="viernes">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Sabado</label>
                                      <input type="text" name="apertura[]" id="sem11" class="form-control"  value="{{ @$dias[5]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem12" class="form-control"  value="{{ @$dias[5]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="sabado">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="page">Domingo</label>
                                      <input type="text" name="apertura[]" id="sem13" class="form-control"  value="{{ @$dias[6]->starhour }}" placeholder="Apertura">
                                      <input type="text" name="cierre[]" id="sem14" class="form-control"  value="{{ @$dias[6]->endhour }}" placeholder="Cierre">
                                      <input type="hidden" name="day[]" value="dominigo">
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                              
                              <fieldset id="vacaciones">
                                  <legend>Vacaciones</legend>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="page">Vacaciones 1</label>
                                        <input type="text" name="vacacion[]" id="sem15" class="form-control"  value="{{ @$vacaciones[0]->startdate }}" placeholder="Desde">
                                        
                                    </div> 

                                    <div class="form-group">
                                        <label for="page">Vacaciones 2</label>
                                        <input type="text" name="vacacion[]" id="sem16" class="form-control"  value="{{ @$vacaciones[1]->startdate }}" placeholder="Desde">
                                       
                                    </div> 

                                    <div class="form-group">
                                        <label for="page">Vacaciones 3</label>
                                        <input type="text" name="vacacion[]" id="sem17" class="form-control"  value="{{ @$vacaciones[2]->startdate }}" placeholder="Desde">
                                        
                                    </div> 

                                    <div class="form-group">
                                        <label for="page">Vacaciones 4</label>
                                        <input type="text" name="vacacion[]" id="sem18" class="form-control"  value="{{ @$vacaciones[3]->startdate }}" placeholder="Desde">
                                       
                                    </div> 
                                  </div>
                          </fieldset>

                          <fieldset>
                            <legend>Geolocalización</legend>

                              <div class="form-group">
                                  <label for="direccion">Dirección</label>
                                  <input type="text" name="address" class="form-control" id="address" value="{{ @$profile->address }}" placeholder="Ingrese dirección">
                                  <a href="#" class="btn btn-default btn-xs" id="buscar">Geolocalizar</a>
                              </div>
                          </fieldset>
                              
                                <input type="hidden" name="latitud" id="latitud" value="{{ @$profile->latitud }}">
                                <input type="hidden" name="longitud" id="longitud" value="{{ @$profile->longitud }}">
                              <div id="getdot">
                              
                              </div>
            
                              
                            </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger btn-save-glosario">Guardar</button>
                          </div>
                      </form>
                    </div>
                </div>
        </div>
       
    </div>
</div>
</section>
<form id="fr-delete">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="DELETE">  
</form>

      <script>
 
          var marker;
      
          function initMap() {
			 
			  @if($profile)
            var myLatLng = {lat: {{ @$profile->latitud }}, lng: {{ @$profile->longitud }}};
			  @else
			 var myLatLng = {lat: 40.4381307, lng: -3.8199653 };  
			  @endif

            var map = new google.maps.Map(document.getElementById('getdot'), {
              zoom: 12,
			 @if($profile)
              center: {lat: {{ @$profile->latitud }}, lng: {{ @$profile->longitud }}}
			 @else
				center: {lat: 40.4381307, lng: -3.8199653 }
			 @endif
            });
            var geocoder = new google.maps.Geocoder();
            
            document.getElementById('buscar').addEventListener('click', function(e) {
              event.preventDefault();
              geocodeAddress(geocoder, map);
            });
          
            var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              title: '{{ @$profile->tradename }}'
            });
          }
      
          function geocodeAddress(geocoder, resultsMap) {
            var address = document.getElementById('address').value;
            geocoder.geocode({'address': address}, function(results, status) {
              if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
               
                $("#latitud").val(lat);
                $("#longitud").val(lng);
      
                var marker = new google.maps.Marker({
                  map: resultsMap,
                  position: results[0].geometry.location
                });
              } else {
                alert('Geocode was not successful for the following reason: ' + status);
              }
            });
          }
      
      </script>
      
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn9eQmmhf88EIDadcj0XpL55E-9PziPME&callback=initMap"
      async defer></script>
@endsection
