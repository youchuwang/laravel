<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		@section('title') 
		@show 
	</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="shortcut icon" href="favicon.ico" />
	
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,100Italic,300,300Italic,500,500Italic,700,700Italic,900,900Italic' />
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,100Italic,300,300Italic,500,500Italic,700,700Italic,900,900Italic' />
	
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/metro.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
<div class="header">
	<div class="wrap clear">
		<img src="{{ asset('images/logo.png') }}" alt="" />
		<div class="button_wrap">
			<?php /*
			@if (Sentry::check())			
			<a href="/users/{{ Session::get('userId') }}" class="button green"><span {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }} >{{ Session::get('email') }}</span></a>
			<a href="{{ URL::to('dashboard') }}" class="button green"><span>Dashboard</span></a>
			<a href="{{ URL::to('logout') }}" class="button green"><span>Logout</span></a>
			@else
			<a href="{{ URL::to('login') }}" class="button green"><span {{ (Request::is('login') ? 'class="active"' : '') }} >Login to My Account</span></a>
			<a href="{{ URL::to('users/create') }}" class="button green"><span {{ (Request::is('users/create') ? 'class="active"' : '') }} >Register</span></a>
			@endif
			*/ ?>
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
	<div class="line"></div>
</div>
<!-- Notifications -->
@include('layouts/notifications')
<!-- ./ notifications -->

<div class="banner">
	<div class="wrap clear">
		<h1>We Keep Your Website Up 24 Hours, 365 Days!</h1>
		<p>Monitor, Alert & Help!</p>
		<h2>Want to know more?</h2>
		<div class="button_wrap clear">
			<div class="col six align-right"><a id="btn_works" class="button orange"><span>How It Works</span></a></div>
			<div class="col six align-left"><a id="btn_plans" class="button green"><span>Pricing Plans</span></a></div>
		</div>
	</div>
</div>
<div class="agreement">
	<div class="wrap clear">
		<div class="title">
			<p>Hello there, stranger!</p>
			<p>Welcome to keep us up.</p>
			<p>Here is why we are different from the rest.</p>
		</div>
		<div class="line"></div>
		<div class="col four">
			<div class="icons service"></div>
			<h3>Fast & Reliable Service</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took</p>
		</div>
		<div class="col four">
			<div class="icons experts"></div>
			<h3>Industry Experts</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took</p>
		</div>
		<div class="col four">
			<div class="icons fees"></div>
			<h3>No Hidden Fees</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took</p>
		</div>
	</div>
</div>
<div class="workflow">
	<div class="wrap clear">
		<h2>So, as you now know who we are <br />Let’s see how our system works, shall we?</h2>
		<div class="row_wrap">
			<div class="row clear align-left row1">
				<div class="icons num"><div>1</div></div>
				<div class="col five icon">
					<div class="icons icon1"></div>
				</div>
				<div class="col five txt">
					<span class="icons arrow"></span>
					<h3>Monitor</h3>
					<p>Multiple monitoring servers around the world run protocol based tests on your website at specific intervals (every 2, 5, 15, 30 or 60 minutes) 24 hours per day, 7 days per week, 365 days per year to ensure that your customers and users can reach your website.</p>
				</div>
			</div>
			<div id="row_alert" class="row clear align-right row2">
				<div class="icons num"><div>2</div></div>
				<div class="col five txt">
					<span class="icons arrow"></span>
					<h3>Alert</h3>
					<p>If more than one monitoring location detects a connection failure or error, an email or SMS alert is sent to you. Our system will also notify you when you website becomes available again.</p>
				</div>
				<div class="col five icon">
					<div class="icons icon2"></div>
				</div>
			</div>
			<div class="row clear align-left row3">
				<div class="icons num"><div>3</div></div>
				<div class="col five icon">
					<div class="icons icon3"></div>
				</div>
				<div class="col five txt">
					<span class="icons arrow"></span>
					<h3>Help</h3>
					<p>We are here to help you as well. Our technical support staff is there to assist you in solving your technical problems of any type, even ones not related to our service. Simply reach out to us.</p>
				</div>
			</div>
			<div id="gotop" class="row clear align-left last">
				<div class="icons num"></div>
			</div>
			<div class="line"></div>
		</div>
		<div class="button_wrap clear">
			<div class="col six align-right"><a class="btn_plans button red"><span>Pricing Plans</span></a></div>
			<div class="col six align-left"><a id="btn_contact" class="button green"><span>Contact Us</span></a></div>
		</div>
	</div>
</div>
<div class="price">
	<div class="wrap clear">
		<div class="col seven">
			<h2>Got your attention yet?<br />Take a look at our trial package!</h2>
			<p>After extensive marketing research keepusup.com has come up with an easy to afford trail package with competitive pricing package to suit everyone’s needs. However as we expand we will be introducing more options to suit everybody’s requirements. Don’t miss out the oppotunity to know about what is happening with us. </p>
			<h3>Sign up for our news letter!</h3>
			<form>
				<input type="text" value="Your email address goes here" />
				<div class="button_wrap clear">
					<a href="#" class="button red"><span>SUBSCRIBE NOW</span></a>
				</div>
			</form>
		</div>
		<div class="col five">
			<div class="list_wrap">
				<ul>
					<li class="first">Trail Pack</li>
					<li class="fee">$ 10.00</li>
					<li>3 Monitors</li>
					<li>10 Minute Checks</li>
					<li>DNS Monitoring</li>
					<li>Statustics Download</li>
					<li>XML Statistics</li>
					<li>Multiple Alert Contacts</li>
					<li class="last"><a href="#" class="button red"><span>START TRIAL</span></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="contact">
	<div class="wrap clear">
		<h2>What more can we say?<br />Sit back, relax and enjoy while we work.</h2>
		<div class="col seven">
			<form>
				<h3>We are here to talk, if you want to know more.</h3>
				<ul>
					<li><input type="text" value="What do your friends call you?" /></li>
					<li><input type="text" value="What is your email address?" /></li>
					<li><textarea>What is it that you want to know?</textarea></li>
					<li class="align-right"><a href="#" class="button red"><span>SEND AWAY!</span></a></li>
				</ul>
			</form>
		</div>
	</div>
</div>
<div class="footer">
	<div class="wrap clear">
		<div class="col eight"><p>Copyright © 2013 KeepUsUp.com. All Rights Reserved. </p></div>
		<div class="col four align-right">
			<ul>
				<li><div class="icons icon1"></div></li>
				<li><div class="icons icon2"></div></li>
				<li><div class="icons icon3"></div></li>
				<li><div class="icons icon4"></div></li>
				<li><div class="icons icon5"></div></li>
			</ul>
		</div>
	</div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo-min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/uniform/jquery.uniform.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.blockui.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script language="javascript">
jQuery(document).ready(function() {     
	App.initLogin();

	jQuery(".banner a.button,.workflow a.button,.workflow .num,.agreement .icons").hover(
		function(){jQuery(this).parent().addClass("active");},
		function(){jQuery(this).parent().removeClass("active");}
	);
	jQuery('#btn_works').click(function(){
		jQuery.scrollTo('.workflow',600,{offset:{top:-50,left:0}});
	});
	jQuery('.btn_plans').click(function(){
		jQuery.scrollTo('.price',600,{offset:{top:-50, left:0}});
	});
	jQuery('#btn_contact').click(function(){
		jQuery.scrollTo('.contact',600,{offset:{top:-50, left:0}});
	});
});
</script>
</body>
</html>