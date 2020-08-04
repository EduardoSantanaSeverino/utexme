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
		
		(function () {
		
		var ordersListing = document.getElementById("ordersListing");

		ordersListing.dispatchEvent(new CustomEvent("ordersReceived", {
			detail: {
				orderCount: 5
			},
			bubbles: true,
			cancelable: false
		}));

		var ordersReceived = document.getElementById("ordersReceived");
		
		var ordersReceivedEvent = new CustomEvent("ordersReceived", {
			bubbles: true, 
			cancelable: true
		});

		ordersReceived.dispatchEvent(ordersReceivedEvent);
		ordersListing.addEventListener("orders", showOrders);
		crdersLis.addEventListener("ordersReceived", showOrdersReceivedCount);
		
		})();


    </script>

@endsection
