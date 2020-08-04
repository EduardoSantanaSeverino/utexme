<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">Name</label>

	<div class="col-md-6">

		{!! Form::text('name', null, ['class' => 'form-control']) !!}
		@if ($errors->has('name'))
		<span class="help-block">
			<strong>{{ $errors->first('name') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">E-Mail Address</label>

	<div class="col-md-6">

		{!! Form::text('email', null, ['class' => 'form-control']) !!}
		@if ($errors->has('email'))
		<span class="help-block">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">Password</label>

	<div class="col-md-6">
		<input type="password" class="form-control" name="password">

		@if ($errors->has('password'))
		<span class="help-block">
			<strong>{{ $errors->first('password') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">Confirm Password</label>

	<div class="col-md-6">
		<input type="password" class="form-control" name="password_confirmation">

		@if ($errors->has('password_confirmation'))
		<span class="help-block">
			<strong>{{ $errors->first('password_confirmation') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group">
	<div class="col-md-6 col-md-offset-4">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-btn fa-user" aria-hidden="true"></i> {{ $submitButton }}
		</button>
	</div>
</div>
