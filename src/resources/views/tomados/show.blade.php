@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row">
          <div class="col-md-12">
               <div class="panel panel-default">
                    <div class="panel-heading">
                         {{$tomarExamen -> examen -> Nombre}} 

                         @can('perms',['ver-examenes-crear'])
                         {!! Form::model($tomarExamen , [ 'method' => 'POST', 'action' => ['TomarExamenController@notificar', $tomarExamen -> id]]) !!}
                         <button type="submit" class="btn btn-danger boton-index-nuevo boton-nuevo-custom" id="btnEnviar" style="    margin-top: -27px;">
                              Enviar Resultados
                         </button>
                         {!! Form::close() !!}
                         @endcan
                    </div>
                    <div class="panel-body">
                         @if ($message = Session::get('success'))
                         <div class="alert alert-success">
                              <p>{{ $message }}</p>
                         </div>
                         <div class="clearfix"></div>
                         @endif
                         <h4>
                              <span class="label label-success pull-right">{{$tomarExamen -> usuario -> name}}</span>
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
                              Time: {{ $tomarExamen -> Minutos }} Minutes
                         </div>
                         <div class="clearfix" style="margin-bottom: 20px;"></div>

                         <ul class="list-group">

                              @forelse($tomarExamen -> tomarExamenDetalles as $det)
                              <li class="list-group-item">
                                   <div class="pull-right">
                                        <h4>
                                             @if($det -> Correcto == 1)
									<span class="label label-success"> 
										<i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                            
                                             @else
									<span class="label label-danger"> 
										  <i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                            
                                           
                                             @endif
                                        </h4>
                                   </div>
                                   
                                   <p><strong>{{$det -> Orden}}. - {{$det -> pregunta -> Nombre}}</strong></p>
                                   @if (empty($det -> pregunta -> Descripcion) == false)
                                        <p>{{$det -> pregunta -> Descripcion}}</p>
                                   @endif

                                   @if (empty($det -> pregunta -> Imagen) == false)
                                        @php
                                        list($width, $height) = getimagesize('http://' . $_SERVER['SERVER_NAME'] . $det -> pregunta -> Imagen);
                                        @endphp
                                        <div class="imagen-fondo" style="height: {{$height}}px; background-image: url('{{$det -> pregunta -> Imagen}}'); background-size: {{( $width > 800 ? $width - 100 : $width )}}px;"></div>
                                   @endif
                                   
                                   <hr style="margin-top: 0px; margin-bottom: 10px;"/>

							@if(!empty($det -> opcion))
                                   <p>{{ $det -> opcion -> Nombre}}</p>
							
                                   @if (empty($det -> opcion -> Descripcion) == false)
                                   <p class="list-group-item-text">{{$det -> opcion -> Descripcion}}</p>
                                   @endif
                                   
                                   @if (empty($det -> opcion -> Imagen) == false)
                                        @php
                                        list($width2, $height2) = getimagesize('http://' . $_SERVER['SERVER_NAME'] . $det -> opcion -> Imagen);
                                        @endphp
                                        <p><div class="imagen-fondo" style="height: {{$height2}}px; background-image: url('{{$det -> opcion -> Imagen}}'); background-size: {{( $width2 > 800 ? $width2 - 100 : $width2 )}}px;"></div></p>
                                   @endif
							@endif
							
							@if(!empty($det -> Comentario))
								<div>
									<textarea disabled="disabled" placeholder="Propia Respuesta" class="form-control" style="height:100px" cols="50" rows="10">{{ $det -> Comentario}}</textarea>
								</div>
							@endif
							<div class="clearfix"></div>
                              </li>
                              @empty
                              <li class="list-group-item">
                                   <p>No hay preguntas en el listado</p>
                              </li>   
                              @endforelse

                         </ul>
                    </div>
                    <!--				<hr style="margin-top: 0px; margin-bottom: 0px;">-->
               </div>
          </div>
     </div>
</div>
@endsection

