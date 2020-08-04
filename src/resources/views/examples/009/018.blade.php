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

<div id="yellow" style="background-color: yellow">My yellow content</div>
<div id="blue" style="background-color: blue">My blue content</div>
<div id="red" style="background-color: red">My red content</div>

@section('scripts')

    <script>
		
		(function () {
			//document.getElementById("blue").style.display = "none";
			$("#blue").css("visibility","hidden");
		})();

    </script>

@endsection
