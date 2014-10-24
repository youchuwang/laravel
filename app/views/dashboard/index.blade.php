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
		<div class="beta-container">
			<div id="dashboard">
				<div class="row-fluid content-header">
					<div class="span12">
						<div class="pull-left">
							<h3>Dashboard</h3>
						</div>
						<div id="wt-target-1" class="pull-right">
							<a href="#" id="add_site_btn" class="pull-right open_inner_page" main_id="dashboard" modal_id="contact-support-add-another-site">Add Site</a>
							<p class="pull-right add-site-description">Would you like to <br/>check another site?</p>
						</div>
					</div>
				</div>
				<div id="dashboard-section-mask"></div>
				<div id="check-list">
					<?php $index = 0; ?>
					@foreach( $check_list as $domain => $datalist )
						<?php $index++; ?>
					<div class="domain-section" id="domain-section-<?php echo $index; ?>">
						<div class="row-fluid site-url-section">
							<div class="span12">
								<h5 id="site-url-section-<?php echo $index; ?>">{{ $domain }}</h5>
							</div>
						</div>
						<div class="clearfix"></div>
							@foreach( $datalist as $data )
							<div class="row-fluid site-data-section"  id="check_row_{{ $data['check_id'] }}">
								<div class="row-fluid">
									<div class="span12 url-detail-title">
										<a href="{{ $data['url'] }}" class="{{ $data['type'] }}-label mytooltip bottom url-detail-title-<?php echo $index; ?>" data-tool="{{ $data['url'] }}" checktype="{{ $data['type'] }}" mongoid="{{ $data['mongo_id'] }}" checkid="{{ $data['check_id'] }}" passday="{{ $data['passday'] }}" is_paused="{{ $data['is_paused'] }}">{{ $data['path'] }}</a>
									</div>
								</div>
								<div class="row-fluid">
									<div class="pull-left" style="width:47%;padding:0 1% 0 2%;">
										<div class="row-fluid">
											<div>
												<span class="progress {{ $data['check_value']['uptime_progress_class'] or '' }}" style="display:block;">
													<span style="width: {{ $data['check_value']['uptime_progress_val'] or '0' }}%;" class="bar pull-right"></span>
												</span>
												<span class="task text-right">
													<span class="pull-right check-value-label">Availability</span>
													<span class="pull-right check-value-data {{ $data['check_value']['uptime_progress_class'] or '' }}">
														{{ isset($data['check_value']['uptime']) ? $data['check_value']['uptime'] . '%' : 'Data Not Available' }}
													</span>
													@if( isset($data['check_value']['uptime_warning']) && $data['check_value']['uptime_warning'] )
													<a href="{{ URL::route('contact-support') }}" class="pull-right fix-this-btn">Fix This</a>
													@endif
												</span>
											</div>
										</div>
									</div>
									<div class="pull-right @if(isset($data['check_value']['response_speed_warning']))wt-helper-fix @endif" style="width:47%;padding:0 1% 0 2%;">
										<div class="row-fluid">
											<div>
												<span class="progress {{ $data['check_value']['response_speed_progress_class'] or '' }}" style="display:block;">
													<span style="width: {{ $data['check_value']['response_speed'] or '0' }}%;" class="bar"></span>
												</span>
												<span class="task">
													<span class="check-value-label">Response Speed</span>
													<span class="check-value-data {{ $data['check_value']['response_speed_progress_class'] or '' }}">
														{{ isset($data['check_value']['response_speed_text']) ? $data['check_value']['response_speed_text'] : 'Data Not Available' }}
													</span>
													@if( isset($data['check_value']['response_speed_warning']) &&   $data['check_value']['response_speed_warning'] )
													<a href="{{ URL::route('contact-support') }}" class="fix-this-btn">Fix This</a>
													@endif
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<div class="clearfix"></div>
						<div class="row-fluid detail-section">
							<div class="span12">
								<a class="see_detail_btn" href="" data-index="<?php echo $index; ?>">See Details</a>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="clearfix h10"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		@include('dashboard/innerdialog')
		<div class="clearfix"></div>
		<div id="graph-section-bar" class="hide">
			<div id="graph_drawing_progress" class=""></div>
			<div id="dashboard-graph-header">
				<div id="dashboard-graph-header-inner" class="beta-container">
					<span>Details for</span>
					<div class="clearfix"></div>
					<h5 id="graph-title"></h5>
					<a href="#" class="pull-right" id="graph-section-close"><img src="assets/img/remove-kuu-close.png"/></a>
				</div>
			</div>
			<div class="clearfix"></div>
			<div id="dashboard-graph-page-list">
				<div class="beta-container">
					<div class="graph-page-list-items">
					</div>
					<div class="clearfix"></div>
					<a href="#" class="graph-page-prev"></a>
					<a href="#" class="graph-page-next"></a>
				</div>
			</div>
			<div class="clearfix"></div>
			<div id="dashboard-graph-page-content" class="hide">
				<div class="beta-container">
					<div id='date-selector'>
						<select id="check_report_period_select" class="hide">
							<option value="day">Day</option>
							<option value="week" selected="selected">Week</option>
							<option value="month">Month</option>
							<option value="months">Months</option>
						</select>
						<div class="graph-date-selection">
							<ul class="graph-time-stamp">
								<li class="select-time-stamp" combo-val="day" workday="1"><a href="#">Day</a></li>
								<li combo-val="week" workday="7"><a href="#">Week</a></li>
								<li combo-val="month" workday="28"><a href="#">Month</a></li>
								<li combo-val="months" workday="90"><a href="#">Months</a></li>
							</ul>
							<span class="graph-date-range"></span>
							<div class="clearfix"></div>
						</div>
						<div class="uptimebar-section">
							<div class="uptimebar-graph"></div>
							<div class="uptimebar-graph-label"></div>
						</div>
					</div>

					<div id='graph-area'>
						<ul class="data-selection-list">
							<li class="showing-type select-data-item" type="Availability">
								<div>Availability</div>
								<div id="availability_value" class="value"></div>
							</li>
							<li class="showing-type" type="Downtime">
								<div>Downtime</div>
								<div id="downtime_value" class="value"></div>
							</li>
							<li class="showing-type" type="Response Time">
								<div>Response Time</div>
								<div id="response_time_value" class="value"></div>
							</li>
							<li class="showing-type" type="Responsiveness">
								<div>Responsiveness</div>
								<div id="responsiveness_value" class="value"></div>
							</li>
							<!--li class="data-selection-list-btn">
								<a href="#" id="data-selection-list-suspend-btn">Suspend</a>
							</li//-->
							<!--li class="data-selection-list-btn">
								<a href="#" id="data-selection-list-edit-btn">Edit</a>
							</li//-->
						</ul>
						<div class="clearfix"></div>
						<div id="container" style="min-width: 310px; height: 400px; margin: 45px auto 0"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="notification-email-content">
				<div id="notification-email-content-inner" class="beta-container">
					<h5>Notification Emails
						<a href="#" class="data-selection-remove-btn hide" id="data-selection-list-unsuspend-btn">UnSuspend</a>
						<a href="#" class="data-selection-remove-btn hide" id="data-selection-list-delete-btn">Delete</a>
						<a href="#" class="data-selection-remove-btn" id="data-selection-list-suspend-btn">Suspend</a>
						<a href="#" id="data-selection-list-edit-btn">Edit</a>
					</h5>
					<ul id="detail_notification_email">
					</ul>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer-page-container">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12">
					<span>&copy; 2014 keepusup.com. All Rights Reserved.</span>
					<span class="pull-right text-right">
						<a href="{{ URL::route('privacy-policy') }}">Privacy Policy</a> | <a href="{{ URL::route('terms-of-use') }}">Terms of Use</a>
					</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

@section ('getgraphdataform')

	{{ Form::open( array(
		'route' => 'getgraphdata',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'getgraphdataform'
	) ) }}
		<input type="hidden" id="report_mongo_id" name="report_mongo_id" value=""/>
		<input type="hidden" id="check_report_period" name="check_report_period" value=""/>
		<input type="hidden" id="report_check_id" name="report_check_id" value=""/>
	{{ Form::close() }}

@show
	
	{{ Form::open( array(
		'route' => 'checksite.suspendcheck',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'suspendcheckform'
	) ) }}
		<input type="hidden" id="suspend_check_id" name="suspend_check_id" value=""/>
		<input type="hidden" id="suspend_mongo_id" name="suspend_mongo_id" value=""/>
		<input type="hidden" id="suspend_is_paused" name="suspend_is_paused" value=""/>
	{{ Form::close() }}
	
	{{ Form::open( array(
		'route' => 'checksite.deletecheck',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'deletecheckform'
	) ) }}
		<input type="hidden" id="del_check_id" name="del_check_id" value=""/>
		<input type="hidden" id="del_mongo_id" name="del_mongo_id" value=""/>
	{{ Form::close() }}
	
	{{ Form::open( array(
		'route' => 'checksite.refresh',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'checksiterefresh'
	) ) }}
	{{ Form::close() }}

	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/highcharts.js') }}"></script>
	<script src="{{ asset('js/jquery.input-ip-address-control-1.0.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
	<script src="{{ asset('assets/js/add_another_site.js') }}"></script>
	<script src="{{ asset('assets/js/site_more_info.js') }}"></script>	

	@yield('walkthrough')
</body>
</html>