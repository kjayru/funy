@extends('layouts.master')

@section('content')
<section class="content-header">
        <h1>Categorias</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Categorias</li>
          
        </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                
            </div>
                <div class="box-body">
            

        
                            <a href="#" class="btn btn-xs btn-default btn-nuevo-categoria"  data-toggle="modal" data-target="#modal-nuevolista">Nuevo Categoria</a>

                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Categoria</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registros as $key => $reg)
                                        @if($reg->childs->count()>0)   
                                           <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $reg->name }} </td>
                                                
                                                
                                                <td>{{ $reg->updated_at }}</td>
                                                <td>
                                                        <a href="#" data-id="{{$reg->id}}"  class="btn btn-default btn-editar-category btn-xs">Editar</a>
                                                        <a href="#" data-id="{{$reg->id}}" class="btn btn-danger btn-borrar-category btn-xs">Borrar</a>
                                                </td>
                                            </tr>
                                            @foreach($reg->childs as $sub)
                                            <tr class="subpage">
                                                    <th scope="row"></th>
                                                    <td>-- {{ $sub->name }} </td>
                                                    
                                                   
                                                    <td>{{ $sub->updated_at }}</td>
                                                    <td>
                                                            <a href="#" data-id="{{$sub->id}}"  class="btn btn-default btn-editar-category btn-xs">Editar</a>
                                                            <a href="#" data-id="{{$sub->id}}" class="btn btn-danger btn-borrar-category btn-xs">Borrar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td>{{ $reg->name }} </td>
                                            
                                           
                                            <td>{{ $reg->updated_at }}</td>
                                            <td>
                                                    <a href="#" data-id="{{$reg->id}}"  class="btn btn-default btn-editar-category btn-xs">Editar</a>
                                                    <a href="#" data-id="{{$reg->id}}" class="btn btn-danger btn-borrar-category btn-xs">Borrar</a>
                                            </td>
                                        </tr>
                                        @endif
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
						@if(count($registros)==0)
							 disabled
						@endif
					   >
                        <option value="0">Seleccione</option>
                         @foreach($registros as $rg)
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
							 @if(count($registros)==0)
							 disabled
							@endif
							>
                                <option value="0">Seleccione</option>
                                 @foreach($registros as $rg)
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
