@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Administracion de Roles</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ route('roles.create') }}"> Crear Nuevo Rol</a>
			</div>
		</div>
	</div>
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Nombre</th>
			<th>Descripcion</th>
			<th>Permisos</th>
			<th width="290px">Accion</th>
		</tr>
		@foreach ($roles as $key => $role)
		<tr>
			<td>{{ ++$i }}</td>
			<td>{{ $role->display_name }}</td>
			<td>{{ $role->description }}</td>
			<td>
				@if(!empty($role->perms))
				@foreach($role->perms as $v)
				<label class="label label-success">{{ $v->display_name }}</label>
				@endforeach
				@endif
			</td>
			<td>
				<a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Ver</a>
				<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Editar</a>
				{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
				{!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
				{!! Form::close() !!}
			</td>
		</tr>
		@endforeach
	</table>
	{!! $roles->render() !!}
</div>
@endsection