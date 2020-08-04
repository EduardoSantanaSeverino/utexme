<div id="PreguntasTableContainer"></div>

@section('scripts')

    <script>
        var tituloTabla = "Preguntas registradas para examen";
        var ExamenId ="{!! $examen -> id !!}";
        var tokenValList = "{{csrf_token()}}";
        var tokenValCreate = "{{csrf_token()}}";
        var tokenValUpdate = "{{csrf_token()}}";
        var tokenValDelete = "{{csrf_token()}}";
    </script>

    <link href="{{ url('/js/jquery-ui/flick/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('/js/jtable/themes/jqueryui/jtable_jqueryui.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ url('/js/jquery-ui/flick/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/jtable/jquery.jtable.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/jtable/localization/jquery.jtable.es.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/number_format.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/cargarModel.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/preguntas/edit.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/preguntas/examenChanged.js') }}"></script>

@endsection
