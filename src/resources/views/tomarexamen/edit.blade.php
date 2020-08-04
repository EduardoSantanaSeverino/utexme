@extends('layouts.apptomarexamen')
@section('examname')
- {{$tomarExamen -> examen -> Nombre}}
@endsection
@section('counter')
<div class="your-clock"></div>
<div class="message"></div>
@endsection
@section('content')
@php
$i='a';
@endphp
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 style="    float: right;     margin-top: -5px;     margin-bottom: 15px;">Question {{ $tomarExamen -> PreguntaActual }} of {{ $tomarExamen -> TotalPreguntas }}</h3>
			<div class="panel panel-default" style="    clear: both;">
				<div class="panel-heading">
					Question {{ $tomarExamen -> PreguntaActual }}
					@if($tomarExamen -> Editar == 1)
						<span style="
							color: red;
							font-weight: bold;
						"> - Modo de Edicion Activado!</span>
					@endif
				</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> Seleccionar una opcion por favor!<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					@if (empty($tomarExamen -> detalle -> pregunta -> Nombre) == false)
                    	<p>{{$tomarExamen -> detalle -> pregunta -> Nombre}}</p>
                    @endif
					@if (empty($tomarExamen -> detalle -> pregunta -> Descripcion) == false)
						<p>{{$tomarExamen -> detalle -> pregunta -> Descripcion}}</p>
					@endif
					@if (empty($tomarExamen -> detalle -> pregunta -> Imagen) == false)
						@php
							$path = 'http://' . $_SERVER['SERVER_NAME'] . $tomarExamen -> detalle -> pregunta -> Imagen;
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$data = file_get_contents($path);
							$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
							list($width, $height) = getimagesize($path);
						@endphp
						<div class="imagen-fondo" style="height: {{$height}}px; background-image: url('{{$base64}}'); background-size: {{( $width > 800 ? $width - 110 : $width )}}px;"></div>
					@endif

				</div>

				<hr style="margin-top: 0px; margin-bottom: 0px;">

				{!! Form::model($tomarExamen , [ 'method' => 'PATCH', 'action' => ['TomarExamenController@update', $tomarExamen -> id]]) !!}

				<ul class="list-group">

				@php
					if ($tomarExamen -> examen -> OrdenPreguntasFijo == 1)
					{
						$colOpciones = $tomarExamen -> detalle -> pregunta -> opciones() -> orderBy('id') -> get();
					}
					else
					{
						$colOpciones = $tomarExamen -> detalle -> pregunta -> opciones -> shuffle();
					}
				@endphp

				@forelse($colOpciones as $opcion)
					<li class="list-group-item">
                         
						<div class="radio">
							<label>
								<input type="radio" name="OpcionId"
									  	@if($tomarExamen -> detalle -> OpcionId == $opcion -> id) checked @endif
										value="{{$opcion -> id}}">
								<span>{{ $i++ }}.</span> @if (empty($opcion -> Nombre) == false) <span style="
																							margin-left: 5px;
																							border: 1px gray solid;
																							padding-right: 6px;
																							padding-left: 6px;">{{ $opcion -> Nombre }}</span></br> @endif
                                @if (empty($opcion -> Imagen) == false)
                                     @php
                                         $path = 'http://' . $_SERVER['SERVER_NAME'] . $opcion -> Imagen;
                                         $type = pathinfo($path, PATHINFO_EXTENSION);
                                         $data = file_get_contents($path);
                                         $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                         list($width, $height) = getimagesize($path);
                                     @endphp

                                         <div class="imagen-fondo" style="margin-left: -23px; width: {{$width}}px ;height: {{$height}}px; background-image: url('{{$base64}}'); background-size: {{( $width > 800 ? $width - 100 : $width )}}px;"></div>

                                @endif
							</label>
						</div>
					   @if (empty($opcion -> Descripcion) == false)
							<p class="list-group-item-text">{{$opcion->Descripcion}}</p>
					   @endif
						</li>
					@empty
					<li class="list-group-item ">
						<p class="list-group-item-text">No hay opciones disponibles</p>
					</li>
					@endforelse

				</ul>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Propia Respuesta:</strong>
						{!! Form::textarea  ('Comentario', $tomarExamen -> detalle -> Comentario , array('placeholder' => 'Escribe tu propia respuesta | write your own answer.','class' => 'form-control','style'=>'height:100px')) !!}
					</div>
				</div>
				<div class="panel-body" style="margin-top: -20px;">

					@if ($tomarExamen -> PreguntaActual > 1)
					<button class="btn btn-default btn-lg pull-left" type="submit" name="Anterior" value="1">
						<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
						<span>Anterior </span>
					</button>
					@endif

					@if ($tomarExamen -> PreguntaActual >= $tomarExamen -> TotalPreguntas)
					<button class="btn btn-default btn-lg pull-right" type="submit" name="Siguiente" value="1">
						<span>Finalizar </span>
						<i class="fa fa-flag-checkered" aria-hidden="true"></i>
					</button>
					@else
					<button class="btn btn-default btn-lg pull-right" type="submit" name="Siguiente" value="1">
						<span>Siguiente </span>
						<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
					</button>
					@endif

					<div class="clearfix"></div>

				</div>

				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<link rel="stylesheet" href="/js/fc/flipclock.css">
<script type="text/javascript">
	$(document).ready(function () {
		var diffInSeconds = "{{$diffInSeconds}}";
		var clock = $('.your-clock').FlipClock(diffInSeconds, {
			countdown: true,
			callbacks: {
				stop: function() {
					$( "form:first" ).submit();
				}
			}
		});

	});

</script>
<script src="/js/fc/flipclock.min.js"></script>
@endsection
