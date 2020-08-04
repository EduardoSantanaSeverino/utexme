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

			var myApplication = myApplication || {};
			myApplication.LoanCalculator = function (displayControl, principle, term, rate){
				this.Principle = principle;
				this.Term = term;
				this.Rate = rate;
				this.PaymentAmount = 0;
				this.showPayment = document.getElementById(displayControl);
			};
			myApplication.LoanCalculator.prototype = {
				CalculatePayment: function(){
					this.PaymentAmount = (this.Principle * this.Rate / (1 - (Math.pow( 1 / (1 + this.Rate), this.Term)))).toFixed(2);
					this.showPayment.innerHTML = "$" + this.PaymentAmount;
				},
				ShowCanWeAfford: function(){
					if(this.PaymentAmount > 500){
						alert("Denied!");
					}
					else if(this.PaymentAmount < 300){
						alert("Denied!");
					}
					else {
						alert("Approved with caution!");
					}

				}
			};
		
			myApplication.LoanCalculator("output-console", 500, 12, 5)
				.CalculatePayment()
				.ShowCanWeAfford();

		})();


    </script>

@endsection
