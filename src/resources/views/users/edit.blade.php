@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Editar Usuario</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-primary" href="{{ route('users.index') }}"> Atras</a>
			</div>
		</div>
	</div>
	@if (count($errors) > 0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Nombre:</strong>
				{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Email:</strong>
				{!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Activo:</strong>
				{!! Form::checkbox('Activo', 1, ((empty($user) == false) && (empty($user -> Activo) == false)) ,['class' => 'form-control', 'style' => 'width: 30px;']) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Password:</strong>
				{!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Confirmar Password:</strong>
				{!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Enviar Notificacion:</strong>
				{!! Form::checkbox('enviarNotificacion', 1, ((empty($user) == false) && (empty($user -> enviarNotificacion) == false)) ,['class' => 'form-control', 'style' => 'width: 30px;']) !!}
				@if ($errors->has('enviarNotificacion'))
				<span class="help-block">
					<strong>{{ $errors->first('enviarNotificacion') }}</strong>
				</span>
				@endif

			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Role:</strong>
				{!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@endsection