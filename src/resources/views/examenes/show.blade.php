@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Muestra Examen {{$examen->Nombre}}
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label">Examen ID</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{$examen->id}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nombre</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{$examen->Nombre}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Descripcion</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{$examen->Descripcion}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Activo</label>
							<div class="col-sm-10">
								<p class="form-control-static">
									@if ($examen->Activo == 1)
									<span>
										Si
									</span>
									@else
									<span>
										No
									</span>
									@endif
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Creado</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{$examen->created_at}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Modificado</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{$examen->updated_at}}</p>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
