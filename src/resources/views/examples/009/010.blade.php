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
<div class="output-console">
</div>
<div id="MapContents"></div>
<div title="US Map" id="UsMap" style="
    width: 300px;
    height: 200px;
    background: #dfa6a6;
    border: 1px solid #777777;
"></div>

@section('scripts')

    <script>
		
		(function () {
		
			var contents = document.getElementById("MapContents");
			var image = document.getElementById("UsMap");
			image.addEventListener('mousemove', function(e) {
				contents.innerHTML = "x: " + e.x + "<br/>y: " + e.y + "<br/>";
			});
		
		})();


    </script>

@endsection
