@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
		<h3>Listado de Usuarios</h3>
			<div class="panel panel-default">
				<div class="panel-heading">
					Listado de Usuarios
					<a href="{{ url('/usuarios/create') }}" class="btn btn-primary boton-index-nuevo">Crear Usuario</a>
				</div>
				<div class="panel-body">
					<table class="table" cellspacing="0" width="100%">
						<thead>
			            <tr>
			                <th>Id</th>
			                <th>Nombre</th>
			                <th>Email</th>
			                <th>rolId</th>
			                <th>Creado</th>
			                <th>Modificado</th>
			                <th></th>
			            </tr>
			        </thead>
			        <tbody>
				        @forelse($listado as $item)
							<tr>
				                <td>
				                 	<a href="{{action('UsuariosController@show',[$item->id])}}">
					                	{{$item->id}}
					                </a>
					             </td>
				                <td>{{$item->name}}</td>
				                <td>{{$item->email}}</td>
				                <td>{{$item->rolId}}</td>
				                <td>{{$item->created_at}}</td>
				                <td>{{$item->updated_at}}</td>
				                <td>
				                					                <div class="dropdown">
								  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    Actions
								    <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								    <li><a href="{{action('UsuariosController@show',[$item->id])}}"> Detalle </a></li>
								    <li role="separator" class="divider"></li>
								    <li><a href="{{action('UsuariosController@edit',[$item->id])}}"> Editar </a></li>
								    
								  </ul>
								</div>

				                </td>
				            </tr>
						@empty
							<tr>
				                <td colspan="6" style="text-align: center;">
				                	No Hay Usuarios en la lista...
				                </td>
				            </tr>
						@endforelse
			        </tbody>
			    </table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection