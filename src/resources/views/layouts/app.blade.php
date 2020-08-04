<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>U Test Me - Autenticated User</title>

		<!-- Fonts -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

		<!-- Styles -->
		{!! Html::style('css/bootstrap.css') !!}
		{!! Html::style('css/site.css') !!}

		<style>
			body {
				font-family: 'Lato';
				padding-top: 0px !important;
			}

			.fa-btn {
				margin-right: 6px;
			}

			.popover {
				max-width: 900px !important;
				word-wrap: break-word;
			}
		</style>
	</head>
	<body id="app-layout">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand" href="{{ url('/') }}">
						U Test Me
					</a>
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					@if (Auth::guest())
					<span></span>
					@else
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/') }}">Home</a></li>
						
						@can('perms',['ver-tomados'])
						<li><a href="{{ route('tomados.index') }}">Tomados</a></li>
						@endcan
						@can('perms',['ver-tomar'])
						<li><a href="{{ route('tomarexamen.index') }}">Tomar Examen</a></li>
						@endcan
						@can('perms',['view-display-files'])
						<li><a href="{{ route('display.files') }}">View Files</a></li>
						@endcan
						@can('perms',['ver-usuarios','ver-roles','ver-examenes-crear'])
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								Administracion <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								@can('perms',['ver-usuarios'])
								<li><a href="{{ route('users.index') }}">Usuarios</a></li>
								<li role="separator" class="divider"></li>
								@endcan
								@can('perms',['ver-roles'])
                    				<li><a href="{{ route('roles.index') }}">Roles</a></li>
								<li role="separator" class="divider"></li>
								@endcan
								@can('perms',['ver-examenes-crear'])
								<li><a href="{{ route('examenes.index') }}">Examenes</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="{{ url('/permisos') }}">Permisos Examen</a></li>
								@endcan
							</ul>
						</li>
						@endcan
					</ul>
					@endif
					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@if (Auth::guest())
						<li><a href="{{ url('/login') }}">Login</a></li>
						@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="{{ url('/usuarios/' . Auth::user() -> id . '/edit' ) }}">
										<i class="fa fa-btn fa-user-md" aria-hidden="true"></i>Password
									</a>
								</li>
								<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
							</ul>

						</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

		@yield('content')

		<!-- JavaScripts -->
		{!! Html::script('js/jquery-2.2.3.min.js') !!}
		{!! Html::script('js/bootstrap.min.js') !!}
		@yield('scripts')
		<script type="text/javascript">
			$(document).ready(function() {
				$('.navbar-collapse a[href="'+location.href+'"]').parents('li').addClass('active');
				$('[data-toggle="popover"]').popover();
			});
		</script>

		<!-- Modal -->
		<div class="modal fade" id="myModalPopUp1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title"></h3>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="exampleInputEmail1">Material 1</label>
								<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Material 1">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail2">Material 2</label>
								<input type="text" class="form-control" id="exampleInputEmail2" placeholder="Material 2">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail3">Material 3</label>
								<input type="text" class="form-control" id="exampleInputEmail3" placeholder="Material 3">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail4">Material 4</label>
								<input type="text" class="form-control" id="exampleInputEmail4" placeholder="Material 4">
							</div>
						</form>
					</div>
					<!--<div class="modal-footer">-->
					<!--    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
					<!--    <button type="button" class="btn btn-primary">Save changes</button>-->
					<!--</div>-->
				</div>
			</div>
		</div>
	</body>
</html>
