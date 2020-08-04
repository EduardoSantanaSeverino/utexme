<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>U Test Me - Login Form</title>

		{!! Html::style('css/normalize.css') !!}
		{!! Html::style('css/login.css') !!}

	</head>
	<body style="    color: white;">

		<div class="login">
			<h1>Login Me</h1>

			<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
				{!! csrf_field() !!}

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

					<div class="col-md-6">
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">

						@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

					<div class="col-md-6">
						<input type="password" class="form-control" name="password">

						@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group" style="display:none;">
					<div class="col-md-6 col-md-offset-4">
						<div class="checkbox">
							<label style=" color: #fff; text-shadow: 0 0 10px rgba(0,0,0,0.3);">
								<input type="text" name="remember" style="width: 15px;" value="1"> Remember Me
							</label>
						</div>
					</div>
				</div> 

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary btn-block btn-large">
							<i class="fa fa-btn fa-sign-in"></i>Login
						</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
