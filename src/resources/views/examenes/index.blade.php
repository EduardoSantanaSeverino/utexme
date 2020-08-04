@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Listado de examenes
					<a href="/examenes/create" class="btn btn-primary boton-index-nuevo boton-nuevo-custom">Crear Examen</a>
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Activo</th>
								<th>Creado</th>
								<th>Modificado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@forelse($listadoexamenes as $examen)
							<tr>
								<td>
									<a href="{{action('ExamenesController@edit',[$examen->id])}}">
										{{++$i}}
									</a>
								</td>
								<td>{{$examen->Nombre}}</td>
								<td>{{$examen->Descripcion}}</td>
								<td>
									@if ($examen->Activo == 1)
									<span>
										Si
									</span>
									@else
									<span>
										No
									</span>
									@endif
								</td>
								<td>{{$examen->created_at}}</td>
								<td>{{$examen->updated_at}}</td>
								<td>

									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Actions
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<li><a href="{{action('ExamenesController@show',[$examen->id])}}"> Detalle </a></li>
											<li role="separator" class="divider"></li>
											<li><a href="{{action('ExamenesController@edit',[$examen->id])}}"> Editar </a></li>
											<li role="separator" class="divider"></li>
											<li style="text-align: center;">
												@include('examenes._btneliminar', ['submitButton' => 'Eliminar'])
											</li>
										</ul>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="5" style="text-align: center;">
									No Hay examenes en la lista...
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					{{ $listadoexamenes->render() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
