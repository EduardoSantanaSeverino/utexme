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
<ul id="languages">
	<li>HTML</li>
	<li>JavaScript</li>
	<li>Classic APS</li>
	<li>ASP.Net</li>
</ul>

@section('scripts')

    <script>
		
		(function () {

			var languages = [];
			var items = $("#languages li");
			for(var i = 0, l = items.length; i < l; i++)
				languages.push(items[i].innerHTML);
			languages.sort();
			for(var i = 0, l = items.length; i < l; i++)
				items[i].innerHTML = languages[i];


		})();

    </script>

@endsection
