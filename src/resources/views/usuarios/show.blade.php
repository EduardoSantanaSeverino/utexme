@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
		<h3>Muestra el usuario {{$modelo->name}}</h3>
			<div class="panel panel-default">
				<div class="panel-heading">
					Muestra el usuario {{$modelo->name}}
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Id</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->id}}</p>
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Nombre</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->name}}</p>
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Email</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->email}}</p>
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Rol</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->rolId}}</p>
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Creado</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->created_at}}</p>
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2 control-label">Modificado</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$modelo->updated_at}}</p>
					    </div>
					  </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection