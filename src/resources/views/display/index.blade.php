@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="pull-left">
				<h2>View Server Files</h2>
			</div>
			<div class="pull-right">
				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" style="margin-bottom: 15px;">
			<select id="txtUser" class="form-control">
				<option value="">-- Users  --</option>
				@foreach ($usersList as $u)
					<option value="{{ $u['id'] }}" {{ ($u['selected'] ? "selected":"") }} >{{ $u['name'] }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4" style="margin-bottom: 15px;">
			<select id="txtDate" class="form-control">
				<option value="">-- Dates  --</option>
				@foreach ($dateList as $d)
					<option value="{{ $d['id'] }}">{{ $d['name'] }}</option>
				@endforeach
			</select>
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-12">
			@include('display.displayJtable')
		</div>
	</div>
</div>
@endsection