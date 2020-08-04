@extends('layouts.apptomarexamen')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Examenes disponibles
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Intentos</th>
							</tr>
						</thead>
						<tbody>
							@forelse($listadoexamenes as $examen)
							<tr>
								<td>
									<a href="{{action('TomarExamenController@create',['id' => $examen->id])}}">
										{{$examen->Nombre}}
									</a>
								</td>
								<td>
									<a href="{{action('TomarExamenController@create',['id' => $examen->id])}}">
										{{$examen->Descripcion}}
									</a>
								</td>
								<td>
									<a href="{{action('TomarExamenController@create',['id' => $examen->id])}}">
										{{$examen->Cantidad}}
									</a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3" style="text-align: center;">
									No Hay examenes disponibles para tomar ...
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-12">
				<div style="text-align: center;">
					<a href="{{ url('/') }}" class="btn btn-success btn-lg">Atras</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
