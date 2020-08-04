@extends($masterPage)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Importar Preguntas Para Examen
                    </div>
                    <div class="panel-body">
                        <form action="{{ URL::to('examenes/' . $examen->id . '/importexcelpost') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
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
                                <label class="col-sm-2 control-label">Archivo Excel</label>
                                <div class="col-sm-10">
                                    <input style="    padding-top: 7px;" type="file" name="import_file" />
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                    <button class="btn btn-primary">Importar Archivo</button>
                                    <a href="{{ URL::to('examenes/' . $examen->id . '/edit') }}" class="btn btn-default">Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
