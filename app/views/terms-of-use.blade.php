<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Terms of Use</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,100Italic,300,300Italic,500,500Italic,700,700Italic,900,900Italic' />
	
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/metro.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style_responsive.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style_default.css') }}">

	<link rel="shortcut icon" href="favicon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	@include('dashboard/topmenu')
	<div id="main-page-container">
		<div class="beta-container">
			<h1>Terms of Use</h1>
			
			<h2>Limitation of Liability</h2>
			<p>The Company makes every effort to provide accurate and uninterrupted Service and solve all contingency problems with the Service, if these should occur. However, the Company is not responsible for incidental or consequential damages, loss of profit or any other negative consequences connected with the use of the Service</p>
			
			<h2>Service Suspension</h2>
			<p>The Company reserves the right to suspend service to a User with no explanation of the reason.</p>

			<h2>Refund</h2>
			<p>In case the User is not satisfied with the quality of the service provided by the Service in the current or previous month, the Company will pay back all amounts received from the User for the period in question, at his/her first request sent to the Company via e-mail.
</p>
			<h2>Confidentiality of Registration Information</h2>
			<p>The Company does not disclose personal information provided by the User upon registration to any third parties.</p>

			<h2>Cookies</h2>
			<p>Cookies are employed by the Service for user identification and authentication.</p>

			<h2>Session Log</h2>
			<p>When a User is working with the Service Site, information about the Site pages visited by the User is being logged. This information is used to improve the functionality of the Service.</p>

			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
	@include('dashboard/footer')
	
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>