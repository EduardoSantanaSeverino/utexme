@extends('layouts.apptomarexamen')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if ($tomarExamen -> Nota > 69)
			<div class="panel panel-info">
				<div class="panel-heading">
					Resultado de examen <strong> {{ $tomarExamen -> examen -> Nombre }}</strong>
				</div>
				<div class="panel-body">
					<h4>
						<i class="fa fa-smile-o" aria-hidden="true"></i>
						@php
						$fechaTomado = new DateTime($tomarExamen -> FechaInicio);
						@endphp
						Taked on {{ $fechaTomado -> format('Y-m-d') }} at {{ $fechaTomado -> format('H:i') }} hours
					</h4>
					<div class="col-md-6">
						Correct Answers: {{ $tomarExamen -> CantidadCorrectas }}
					</div>
					<div class="col-md-6">
						Total Scored: {{ $tomarExamen -> NotaExamen }}
					</div>
					<div class="col-md-6">
						Incorrect Answers: {{ $tomarExamen -> CantidadErroneas }}
					</div>
					<div class="col-md-6">
						Good Job Boy!
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			@else
			<div class="panel panel-danger">
				<div class="panel-heading">
					Resultado de examen <strong> {{ $tomarExamen -> examen -> Nombre }}</strong>
				</div>
				<div class="panel-body">
					<h4>
						<i class="fa fa-meh-o" aria-hidden="true"></i>
						@php
						$fechaTomado = new DateTime($tomarExamen -> FechaInicio);
						@endphp
						Taked on {{ $fechaTomado -> format('Y-m-d') }} at {{ $fechaTomado -> format('H:i') }} hours
					</h4>
					<div class="col-md-6">
						Correct Answers: {{ $tomarExamen -> CantidadCorrectas }}
					</div>
					<div class="col-md-6">
						Total Scored: {{ $tomarExamen -> NotaExamen }}
					</div>
					<div class="col-md-6">
						Incorrect Answers: {{ $tomarExamen -> CantidadErroneas }}
					</div>
					<div class="col-md-6">
						Better luck next time!
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			@endif
			<div class="col-md-12">
				<div style="text-align: center;">
					<a href="{{ url('/') }}" class="btn btn-success btn-lg">Atras</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
