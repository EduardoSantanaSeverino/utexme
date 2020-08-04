@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Crear Nuevo Examen
				</div>
				<div class="panel-body">

					{!! Form::open(['url' => 'examenes']) !!}

							@include('errors.formerrors')

							@include('examenes._formulario', ['submitButton' => 'Guardar'])

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
