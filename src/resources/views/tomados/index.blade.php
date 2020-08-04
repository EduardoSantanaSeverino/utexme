@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row">
          <div class="col-md-10 col-md-offset-1">
               <div class="panel panel-default">
                    <div class="panel-heading">
                         Listado de examenes tomados
                    </div>
                    <div class="panel-body">
                         <table class="table table-bordered">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Usuario</th>
                                        <th>Examen</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Termino</th>
                                        <th></th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @forelse($data as $tomado)
                                   <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                             <a href="{{action('TomadosController@show',[$tomado->id])}}">
                                                  {{$tomado->usuario->name}}
                                             </a>
                                        </td>
                                        <td>{{$tomado->examen->Nombre}}</td>
                                        <td>{{$tomado->FechaInicio}}</td>
                                        <td>{{$tomado->FechaTermino}}</td>
                                        <td>
                                             <div class="dropdown">
                                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                       Actions
                                                       <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                       <li><a href="{{action('TomadosController@show',[$tomado->id])}}"> Detalle </a></li>
                                                  </ul>
                                             </div>
                                        </td>
                                   </tr>
                                   @empty
                                   <tr>
                                        <td colspan="5" style="text-align: center;">
                                             No Hay registro de examenes tomados ...
                                        </td>
                                   </tr>
                                   @endforelse
                              </tbody>
                         </table>
                         {!! $data->render() !!}
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection
