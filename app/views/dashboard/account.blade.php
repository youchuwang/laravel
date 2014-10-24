<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Account</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,100Italic,300,300Italic,500,500Italic,700,700Italic,900,900Italic' />
	
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/metro.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}">
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
		<div id="account-settings-header-section">
			<div class="beta-container">
				<div class="row-fluid">
					<div class="span12">
						<h1>Account Settings</h1>
						<a href="{{ URL::route('dashboard') }}" class="close close_inner_page" main_id="dashboard" modal_id="contact-support">&nbsp;</a>
					</div>
				</div>
			</div>
		</div>
		<div class="beta-container" id="account-setting-parameter-section">
			<div id="dashboard-section-mask" class="hide"></div>
			<div class="row-fluid">
				<div class="span12" style="text-align:center;">
					<div class="alert hide" id="dontmatch">
						<strong>New Password</strong> and <strong>Confrim Password</strong> doesn't match.
					</div>
					<div class="alert hide" id="moreletters">
						Password have more <strong>8 letters</strong>.
					</div>
					<h1>Personal Details</h1>
					@include('dashboard/account/notification')
					{{ Form::open( array(
						'route' => 'accountupdate-personal',
						'method' => 'post',
						'class' => '',
						'id' => 'accountupdate-personal'
					) ) }}
						<input type="hidden" name="userid" value="{{ $user_id }}"/>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="firstname_error" class="hide">
								<div class="error-label">Please enter valid first name</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">
							<input type="text" class="m-wrap" id="firstname" name="firstname" value="{{ $first_name }}" placeholder="First Name" />
						</div>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="lastname_error" class="hide">
								<div class="error-label">Please enter valid last name</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">
							<input type="text" class="m-wrap" id="lastname" name="lastname" value="{{ $last_name }}" placeholder="Last Name" />
						</div>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="email_error" class="hide">
								<div class="error-label">Please enter valid email address</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">						
							<input type="text" class="m-wrap" id="email" name="email" value="{{ $email }}" placeholder="Email Address" />
						</div>
						<div class="clearfix"></div>
						<input type="submit" class="add_check_btn" value="Update Personal Data" />
					{{ Form::close() }}	
						<div class="clearfix"></div>
						<h1>Password</h1>
					{{ Form::open( array(
						'route' => 'accountupdate-password',
						'method' => 'post',
						'class' => '',
						'id' => 'accountupdate-password'
					) ) }}
						<input type="hidden" name="userid" value="{{ $user_id }}"/>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="currentpassword_error" class="hide">
								<div class="error-label">Please enter correct password</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">
							<input type="password" class="m-wrap" id="currentpassword" name="currentpassword" placeholder="Current Password" />
						</div>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="newpassword_error" class="hide">
								<div class="error-label">Please enter new password</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">
							<input type="password" class="m-wrap" id="newpassword" name="newpassword" placeholder="New Pasword" />
						</div>
						<div class="clearfix"></div>
						<div class="account_setting_error_section">
							<div id="confirmpassword_error" class="hide">
								<div class="error-label">Both passwords are different</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="account_setting_input_section">
							<input type="password" class="m-wrap" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" />
						</div>
						<div class="clearfix"></div>
						<input type="submit" class="add_check_btn" value="Update Password" />
					{{ Form::close() }}	
				</div>
			</div>
		</div>			
		<div class="clearfix"></div>
	</div>
	@include('dashboard/footer')
	
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
	<script src="{{ asset('assets/js/account.js') }}"></script>
</body>
</html>