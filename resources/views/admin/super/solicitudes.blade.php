@extends('layouts.master')

@section('content')
<section class="content-header">
        <h1>Solicitudes</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Solicitudes</li>
          
        </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                
            </div>
                <div class="box-body">
            

        
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Contacto</th>
                            <th scope="col">Email</th>
                            <th scope="col">website</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Fecha</th>
                           
                            
                            
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                      @foreach($solicitudes as $key => $sol)
                        <tr>
                         <th>{{ $key + 1 }}</th> 
                         <td>{{ $sol->admin->name }}</td> 
                         <td>{{ $sol->profile->tradename}}</td> 
                         <td>{{ $sol->profile->contact}}</td>
                         <td>{{ $sol->profile->email}}</td>
                         <td>{{ $sol->profile->website}}</td>
                         <td>{{ $sol->profile->address}}</td>
                        
                        
                         <td>{{ $sol->created_at }}</td>
                            <td>
                                    
                                    <a href="#" data-id="{{ $sol->id }}" class="btn btn-xs btn-danger btn-solicitud-cliente-delete">Eliminar</a>
                                    
                            </td>
                        </tr>
                      @endforeach
                        </tbody>
                </table>          
                       
                   
                        </div>
                    </div>             
                </div>  
        </div>            
 </section>

    <div class="modal modal-default fade" id="modal-nuevolista">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="fr-nuevo-service" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
               
              
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Glosario</h4>
              </div>
              <div class="modal-body">
                  
                  <div class="form-group">
                      <label for="servicios">Servicios</label>
                      <select name="service" id="service" class="form-control">
                      
                          <option value="0">Seleccione</option>
                         

                      </select>
                  </div>
                  <div class="form-group">
                          <label for="subservicios">Sub servicios</label>
                          <select name="subservice" id="subservice" class="form-control">
                              <option value="0">Seleccione</option>
                          </select>
                  </div>

                  <div class="form-group">
                      <label for="typeservice">Tipo de servicio</label>
                      <select name="typeservice" id="typeservice" class="form-control">
                          <option value="0">Seleccione</option>
                          <option value="normal">Normal</option>
                          <option value="avanzado">Avanzado</option>
                          <option value="experto">Experto</option>                                                    

                      </select>
                  </div>

                  <div class="form-group">
                      <label for="resources">Número de recursos</label>
                      <select name="resources" id="resources" class="form-control">
                          <option value="0">Seleccione</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>                                                    

                      </select>
                  </div>
                  <div class="form-group">
                      <label for="executiontime">Tiempo de ejecución</label>
                      <input type="text" name="executiontime" id="picker1" class="form-control" />
                        
                  </div>
                  <div class="form-group">
                      <label for="precio">Precio</label>
                      <input type="text" name="price" id="price" class="form-control" />
                        
                  </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger btn-save-service">Guardar</button>
              </div>
            </form>
        </div>
      </div>
    </div>


    <div class="modal modal-default fade" id="modal-editservice">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="fr-edit-service">
                    {{ csrf_field() }}
                  <input name="_method" type="hidden" value="PUT">
                  <input type="hidden" name="id" id="id" value="">
                
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Editar Servicio</h4>
                </div>
                
                <div class="modal-body">


                    <div class="form-group">
                        <label for="servicios">Servicios</label>
                        <select name="service" id="service" class="form-control">
                        
                            <option value="0">Seleccione</option>
                           
  
                        </select>
                    </div>
                    <div class="form-group">
                            <label for="subservicios">Sub servicios</label>
                            <select name="subservice" id="subservice" class="form-control">
                                <option value="0">Seleccione</option>
                            </select>
                    </div>
  
                    <div class="form-group">
                        <label for="typeservice">Tipo de servicio</label>
                        <select name="typeservice" id="typeservice" class="form-control">
                            <option value="0">Seleccione</option>
                            <option value="normal">Normal</option>
                            <option value="avanzado">Avanzado</option>
                            <option value="experto">Experto</option>                                                    
  
                        </select>
                    </div>
  
                    <div class="form-group">
                        <label for="resources">Número de recursos</label>
                        <select name="resources" id="resources" class="form-control">
                            <option value="0">Seleccione</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>                                                    
  
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="executiontime">Tiempo de ejecución</label>
                        <input type="text" name="executiontime" id="picker1" class="form-control" />
                          
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" name="price" id="price" class="form-control" />
                          
                    </div>
                   
        
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-danger btn-save-edit-service">Guardar</button>
                </div>
            </form>
          </div>
        </div>    
    </div>

<form id="fr-delete">
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="DELETE">  
</form>


@endsection
