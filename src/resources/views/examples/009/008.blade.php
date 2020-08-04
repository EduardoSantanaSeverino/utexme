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
<div onclick="someEvent(event, this);">
	<input type="radio" name="sizeRadio" id="sizeRadioSml" value="1" />
	<label for="sizeRadioSml">Small</label>
	<input type="radio" name="sizeRadio" id="sizeRadioMed" value="2" />
	<label for="sizeRadioMed">Medium</label>
	<input type="radio" name="sizeRadio" id="sizeRadioLrg" value="3" />
	<label for="sizeRadioLrg">Large</label>
</div>
@section('scripts')

    <script>
		function someEvent(event, el) {
			debugger;
			var target = event.srcElement || event.target;
			if (el === target) {
				debugger;
				alert("Some Event Fired! ");
			}
		}
    </script>

@endsection
