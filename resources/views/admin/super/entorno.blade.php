@extends('layouts.master')

@section('content')
<section class="content-header">
        <h1>CONFIGURACIONES DE ENTORNO</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Listado de servicios</li>
          
        </ol>
</section>
<section class="content">
        <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            SERVICIOS
                        </div>
                        <div class="box-body">
            
                                <a href="#" class="btn btn-xs btn-default btn-nuevo-categoria"  data-toggle="modal" data-target="#modal-nuevolista">Nuevo Categoria</a>
                    
        
                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Servicio</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach($servicios as $key => $reg)
                                   @if($reg->childs->count()>0)   
                                   <tr @if($reg->status==1)
									   class="clsoff"
									   @endif
									   >
                                        <th scope="row"> * </th>
                                        <td>{{ $reg->name }} </td>
                                        
                                        
                                       
                                        <td>
                                             <a href="#" data-id="{{$reg->id}}"  class="btn btn-default btn-editar-category btn-xs">Editar</a>
											@if($reg->status==1)
											<a  href="#" class="btn btn-estado btn-xs btn-primary" data-id="{{$reg->id}}" data-estado="2" >Activar</a>
				  							@else
											<a  href="#" class="btn btn-estado btn-xs btn-primary" data-id="{{$reg->id}}" data-estado="1">Desactivar</a>
											@endif
                                             <a href="#" data-id="{{$reg->id}}" class="btn btn-danger btn-borrar-category btn-xs">Borrar</a>
                                        </td>
                                    </tr>
                                    @foreach($reg->childs as $sub)
                                    <tr class="subpage 
											   @if($reg->status==1)
											   clsoff
											   @endif
											   ">
                                            <th scope="row"></th>
                                            <td>-- {{ $sub->name }} </td>
                                            
                                           
                                           
                                            <td>
                                                    <a href="#" data-id="{{$sub->id}}"  class="btn btn-default btn-editar-category btn-xs">Editar</a>
											@if($sub->status==1)
											<a  href="#" class="btn btn-sub-estado btn-xs btn-primary" data-id="{{$sub->id}}" data-estado="2" >Activar</a>
				  							@else
											<a  href="#" class="btn btn-sub-estado btn-xs btn-primary" data-id="{{$sub->id}}" data-estado="1">Desactivar</a>
											@endif
                                                    <a href="#" data-id="{{$sub->id}}" class="btn btn-danger btn-borrar-category btn-xs">Borrar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                
                                @endif
                                  @endforeach
                                      <p>&nbsp;</p>
                                      </tbody>
                            </table>    
                            {{ $servicios->links() }}    
                       
                   
                        </div>
                    </div>             
                </div>  

                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            MODIFICAR DATOS DE ACCESO
                        </div>
                        <div class="box-body">
            

        
                            <form  id="fr-datosacceso" action="/admin/entorno/{{$admin->id}}" method="POST">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="PUT">
                                    <input type="hidden" name="id" id="id" value="{{ $admin->id }}">
                                    
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" placeholder="Email">
                                            @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                    <div class="form-group  {{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                                            <label for="password">Password Anterior</label>
                                            <input type="password" name="oldpassword" class="form-control" placeholder="Password anterior">
                                            @if ($errors->has('oldpassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('oldpassword') }}</strong>
                                            </span>
                                            @endif
                                        </div> 
                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password">Password Nuevo</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password nuevo">
                                            @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    <div class="form-group {{ $errors->has('npassword') ? ' has-error' : '' }}">
                                            <label for="password">Repita Password</label>
                                            <input type="password" name="npassword" class="form-control " placeholder="Repita password">
                                            @if ($errors->has('npassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('npassword') }}</strong>
                                            </span>
                                            @endif
                                    </div> 

                                    <div class="modal-footer">
                                           
                                            <button type="submit" class="btn btn-danger btn-save-mdatas">Guardar</button>
                                    </div>
                            </form> 
                       
                   
                        </div>
                    </div>             
                </div>  
        </div>            
 </section>

 <div class="modal modal-default fade" id="modal-nuevolista">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="fr-nuevo-category" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
               
              <input type="hidden" name="admin_id" id="admin_id" value="{{ $admin_id }}">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva Categoria</h4>
              </div>
              <div class="modal-body">
                  
                  <div class="form-group">
                      <label for="executiontime">Categoria</label>
                      <input type="text" name="nombre"  class="form-control" />
                        
                  </div>
                  <div class="form-group">
                      <label for="herencia">Categoria a heredar</label>
                      <select name="parent_id" class="form-control"
						@if(count($servicios)==0)
							 disabled
						@endif
					   >
							  
                        <option value="0">Seleccione</option>
                         @foreach($servall as $rg)
                        <option value="{{ $rg->id }}">{{ $rg->name }}</option>
                         @endforeach
                      </select>
                        
                  </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
               
				  
			
				
				<button type="button" class="btn btn-danger btn-save-category">Guardar</button>
              </div>
            </form>
        </div>
      </div>
    </div>


    <div class="modal modal-default fade" id="modal-editservice">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="fr-edit-category">
                    {{ csrf_field() }}
                  <input name="_method" type="hidden" value="PUT">
                  <input type="hidden" name="id" id="id" value="">
                  <input type="hidden" name="admin_id" id="admin_id" value="{{ $admin_id }}">
                
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Editar Categoria</h4>
                </div>
                
                <div class="modal-body">

                       
                  <div class="form-group">
                        <label for="executiontime">Categoria o subcategoria</label>
                        <input type="text" name="nombre" id="nombre"  class="form-control" />
                          
                    </div>
                    <div class="form-group">
                        <label for="herencia">Categoria a heredar</label>
                            <select name="parent_id" id="parent_id" class="form-control"
								@if(count($servicios)==0)
							 		disabled
								@endif
							   >
                                <option value="0">Seleccione</option>
                                 @foreach($servall as $rg)
                                <option value="{{ $rg->id }}">{{ $rg->name }}</option>
                                 @endforeach
                            </select>
                          
                    </div>
                   
        
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-danger btn-save-edit-category">Guardar</button>
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
