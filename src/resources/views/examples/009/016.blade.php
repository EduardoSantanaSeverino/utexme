@if (empty($preguntaImagen) == false)
	@php
		$path = 'http://' . $_SERVER['SERVER_NAME'] . $preguntaImagen;
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		list($width, $height) = getimagesize($path);
	@endphp
	<div class="imagen-fondo" style="height: {{$height}}px; background-image: url('{{$base64}}'); background-size: {{( $width > 800 ? $width - 110 : $width )}}px;"></div>
@endif
<div id="output-console" class="output-console">
</div>

<button id="sumit" onclick="alert(start());">Start</button>

@section('scripts')

    <script>
		
		function start(){
			var counter = 10;
			var fun = function(){
				counter = 20;
			}
			return counter;
		}

    </script>

@endsection
