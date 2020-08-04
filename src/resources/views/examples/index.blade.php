@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard de Ejemplos para Examen Id {{$examenId}} y Pregunta {{$preguntaId}}
                </div>
                <div class="panel-body dash-panel">
					@include('examples.' . $examenId . '.' . $preguntaId)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

