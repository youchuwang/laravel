<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Dashboard</title>
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
<body class="dashboard-home">
	@include('dashboard/topmenu')
	<div id="main-page-container">
		<div id="contact-support" class="inner_page_dlg">
			<div id="contact-support-header">
				<div class="beta-container">
					<div class="row-fluid">
						<div class="span12">
							<h1>Contact Support</h1>
							<a href="{{ URL::route('dashboard') }}" class="close" main_id="dashboard" modal_id="contact-support">&nbsp;</a>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="beta-container" id="contact-support-inner">
				<div id="contact-support-page-info" class="row-fluid hide">
					<div class="span12">
						<div class="alert alert-info">
							<p>Your message has been sent successfully. One of our agents will be in touch with you soon.</p>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						{{ Form::open( array(
							'route' => 'contacts.send',
							'method' => 'post',
							'id' => 'contacts-support-page'
						) ) }}
							<div class="contact-parameter-section">
								<label>Name</label>
								<input type="text" class="m-wrap" name="name" value="{{ $first_name }} {{ $last_name }}">
								<label>Email</label>
								<input type="email" class="m-wrap" name="email" value="{{ $useremail }}">
								<label>Category</label>
								<select class="m-wrap" name="category">
									<option value="Support">Support</option>
									<option value="Billing">Billing</option>
									<option value="Sales">Sales</option>
									<option value="Other">Other</option>
								</select>
								<label>Message</label>
								<textarea class="m-wrap" name="message" style="height:150px;"></textarea>
								<div class="clearfix"></div>
								<!--a href="#" class="btn yellow pull-left close_inner_page" main_id="dashboard" modal_id="contact-support">GO BACK</a//-->
								<button type="submit" class="add_check_btn">SEND</button><img id="waiticon" class="pull-right hide" src="assets/img/fancybox_loading.gif" style="margin-right:20px;"/>
							</div>
							<div class="contact-info-section">
								<h1>Beta Service</h1>

								<p>Thank you for using KeepUsUp BETA.  During BETA, our service is entirely FREE.</p> 

								<p>We do ask that if you experience errors or issues with the service, please do contact us immediately, and we will get it resolved.</p>
								
								<h1>Online Support</h1>

								<p>Our mission at KeepUsUp is to help you track and diagnose website performance issues.  This means you can always count on us for a quick, informative, and helpful response from our support staff no matter what the question.</p>

								<p>Our technical support teams stand ready to assist you with all of your technical questions.  Never hesitate to get in touch with us for a first or second opinion on any issue you have.</p>

								<p>Feel free to also email us directly at:  <a href="mailto:support@keepusup.com">support@keepusup.com</a>
							</div>
							<div class="clearfix"></div>
							<p></p>
						{{ Form::close() }}	 		
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	@include('dashboard/footer')
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>