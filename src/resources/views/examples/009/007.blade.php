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
@section('scripts')

    <script>

		(function(){
			
			var nombreServidor = '{{$_SERVER['SERVER_NAME']}}';
			start("http://"+nombreServidor+"/files/example.xml");

			function getStatus(url, callback) {
				debugger;
				var httpRequest = new XMLHttpRequest();
				httpRequest.onreadystatechange = function () {
					if (httpRequest.readyState == 4 && httpRequest.status == 200) {
						debugger;
						callback.call(httpRequest.responseXML);
					}
				};
				httpRequest.open('GET', url);
				httpRequest.send();
			}

			function start(url) {
				getStatus(url, function () {
					processXMLResponse(this);
					var asdfasdfasdfa = this;
					debugger;
				});
			}

			function processXMLResponse(r) {

			}
		})();

    </script>

@endsection
