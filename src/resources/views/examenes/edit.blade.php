@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Modificar Examen {{ $examen -> Nombre }}
				</div>
				<div class="panel-body">

					{!! Form::model($examen , [ 'method' => 'PATCH', 'action' => ['ExamenesController@store']]) !!}

							@include('errors.formerrors')

							@include('examenes._formulario', ['submitButton' => 'Modificar'])

					{!! Form::close() !!}

					<div class="col-md-12">
							@include('examenes.preguntasJtable')
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
