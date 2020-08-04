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

@section('scripts')

    <script>
		
		(function () {

			var var1 = (1 == '1');
			var var2 = (1 === '1');
			var var3 = (false == undefined);
			var var4 = (null == undefined);

			var retVal = "Var1: " + var1 + "<br/>";
			retVal += "Var2: " + var2 + "<br/>";
			retVal += "Var3: " + var3 + "<br/>";
			retVal += "Var4: " + var4 + "<br/>";

			var a = document.getElementById("output-console");

			a.innerHTML = retVal;

		})();


    </script>

@endsection
