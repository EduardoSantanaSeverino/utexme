@extends('layouts.app')

@section('content')
<div class="container">
  @can('perms',['ver-tomar','ver-tomados'])
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
          Dashboard de Examenes
        </div>
        <div class="panel-body dash-panel">
          @php
            $tieneResultados = false;
          @endphp
          @forelse($listado as $i)

            @php
              $tieneResultados = true;
            @endphp
            @if($i -> Nota > 69)
              <div class="bg-info">

                <div class="bs-callout bs-callout-info">
                  <h4 class="pull-right">{{ $i -> examen -> Nombre }}</h4>
                  <h4>
                    <i class="fa fa-smile-o" aria-hidden="true"></i>
                    @php
                      $fechaTomado = new DateTime($i -> FechaInicio);
                    @endphp
                    Taked on {{ $fechaTomado -> format('Y-m-d') }} at
                    {{ $fechaTomado -> format('H:i') }} hours
                  </h4>
                  <div class="col-md-6">
                    Correct Answers: {{ $i -> CantidadCorrectas }}
                  </div>
                  <div class="col-md-6">
                    Total Scored: {{ $i -> NotaExamen }}
                  </div>
                  <div class="col-md-6">
                    Incorrect Answers: {{ $i -> CantidadErroneas }}
                  </div>
                  <div class="col-md-6">
                    Good Job Boy!
                  </div>
                  <div class="clearfix"></div>
                </div>

              </div>
            @else
              <div class="bg-danger">
                <div class="bs-callout bs-callout-warning">
                  <h4 class="pull-right">{{ $i -> examen -> Nombre }}</h4>
                  <h4>
                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                    @php
                      $fechaTomado = new DateTime($i -> FechaInicio);
                    @endphp
                    Taked on {{ $fechaTomado -> format('Y-m-d') }} at
                    {{ $fechaTomado -> format('H:i') }} hours
                  </h4>
                  <div class="col-md-6">
                    Correct Answers: {{ $i -> CantidadCorrectas }}
                  </div>
                  <div class="col-md-6">
                    Total Scored: {{ $i -> NotaExamen }}
                  </div>
                  <div class="col-md-6">
                    Incorrect Answers: {{ $i -> CantidadErroneas }}
                  </div>
                  <div class="col-md-6">
                    Better luck next time!
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            @endif

          @empty
            <div class="col-md-12">
              <div style="text-align: center;">
                <a href="{{ route('tomarexamen.index') }}" class="btn btn-success btn-lg">Tomar Examen!</a>
              </div>
            </div>
          @endforelse
          @if($tieneResultados == true)
            <div class="col-md-12">
              <div style="text-align: center;">
                <a href="{{ route('tomarexamen.index') }}" class="btn btn-success btn-lg">Not te rindas! Tomalo de nuevo!</a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endcan
  @can('perms',['view-display-files'])
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
          Dashboard
        </div>
        <div class="panel-body dash-panel">
          
            <div class="col-md-12">
              <div style="text-align: center;">
                <a href="{{ route('display.files') }}" class="btn btn-success btn-lg">View Files!</a>
              </div>
            </div>
          
        </div>
      </div>
    </div>
  </div>
  @endcan
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('/js/home/index.js') }}"></script>
@endsection