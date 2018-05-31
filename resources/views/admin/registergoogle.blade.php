@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Selecciones el tipo de Usuario</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.custom.updategoogle') }}">
                        {{ csrf_field() }}
                       
						<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Tipo de Usuario</label>
    
                                <div class="col-md-6">
                                   
                                    <select name="role" class="form-control" id="role" required>
                                        <option value="0">Seleccionar</option>
                                        <option value="2">Cliente</option>
                                        <option value="3">Asociado</option>
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                         </div>
				
						
						<input type="hidden" name="name" value="{{ $usersocial->name }}">
						<input type="hidden" name="email" value="{{ $usersocial->email }}">
						<input type="hidden" name="google_id" value="{{ $usersocial->id }}">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
