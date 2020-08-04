@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="pull-left">
				<h2>Permisos de Usuario a Examenes</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-success boton-index-nuevo" href="#">Crear Nuevo Permiso</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="margin-bottom: 15px;">
			<select id="txtUsuario" class="form-control">
				<option value="">-- Usuario  --</option>
				@foreach ($usuarios as $u)
					<option value="{{ $u -> id }}">{{ $u -> name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4" style="margin-bottom: 15px;">
			<select id="txtExamen" class="form-control">
				<option value="">-- Examen  --</option>
				@foreach ($examenes as $e)
					<option value="{{ $e -> id }}">{{ $e -> Nombre }}</option>
				@endforeach
			</select>
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-12">
			@include('permisos.permisosJtable')
		</div>
	</div>
</div>
@endsection