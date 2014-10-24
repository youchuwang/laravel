<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
			@show 
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,100Italic,300,300Italic,500,500Italic,700,700Italic,900,900Italic' />
		
		<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/metro.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/style_responsive.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/style_default.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/uniform/css/uniform.default.css') }}">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body class="
	@section('body_class') 
	@show 
	">
		<!-- Navbar -->
		<div class="container-fluid header-nav">
			<div class="container">
				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN LOGO -->
						<a href="{{ URL::route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="logo" /></a>
						<!-- END LOGO -->
					</div>
					<div class="span6">
						<ul class="header-nav-left-item pull-right">
							@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
							<li {{ (Request::is('users*') ? 'class="active"' : '') }}><a class="btn green" href="{{ URL::to('/users') }}">Users</a></li>
							<li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a class="btn green" href="{{ URL::to('/groups') }}">Groups</a></li>
							@endif
						</ul>
						<ul class="header-nav-left-item pull-right">
							@if (Sentry::check())
							<li {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }}><a class="btn green" href="/users/{{ Session::get('userId') }}">{{ Session::get('email') }}</a></li>
							<li><a class="btn green" href="{{ URL::to('dashboard') }}">Dashboard</a></li>
							<li><a class="btn green" href="{{ URL::to('logout') }}">Logout</a></li>
							@else
							<li {{ (Request::is('login') ? 'class="active"' : '') }}><a class="btn green" href="{{ URL::to('login') }}">Login</a></li>
							<li {{ (Request::is('users/create') ? 'class="active"' : '') }}><a class="btn green" href="{{ URL::to('users/create') }}">Register</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ navbar -->

		
		<!-- Notifications -->
		@include('layouts/notifications')
		<!-- ./ notifications -->

		<!-- Content -->
		@yield('content')
		<!-- ./ content -->
		

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/uniform/jquery.uniform.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.blockui.js') }}"></script>
		<script src="{{ asset('assets/js/app.js') }}"></script>
		<script language="javascript">
			jQuery(document).ready(function() {     
				App.initLogin();
			});
		</script>
	</body>
</html>
