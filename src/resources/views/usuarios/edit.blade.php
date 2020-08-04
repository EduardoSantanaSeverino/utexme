@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Modificar Usuario</div>
				<div class="panel-body">

					{!! Form::model($usuario , [ 'method' => 'PATCH' , 'class' => 'form-horizontal',  'action' => ['UsuariosController@update', $usuario -> id]]) !!}

					@if ($message = Session::get('success'))
					<div class="alert alert-success">
						<p>{{ $message }}</p>
					</div>
					@endif
					
					@include('errors.formerrors')

					@include('usuarios._formulario', ['submitButton' => 'Modificar']) 

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection