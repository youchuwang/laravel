@extends('dashboard.index')

@section ('getgraphdataform')

	{{ Form::open( array(
		'route' => 'getgraphdatawalkthrough',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'getgraphdataform'
	) ) }}
		<input type="hidden" id="report_mongo_id" name="report_mongo_id" value=""/>
		<input type="hidden" id="check_report_period" name="check_report_period" value=""/>
		<input type="hidden" id="report_check_id" name="report_check_id" value=""/>
	{{ Form::close() }}

@show

@section ('walkthrough')
	<link rel="stylesheet" href="{{ asset('assets/css/dashboard.pagewalkthrough.css') }}">

	<script src="{{ asset('assets/js/jquery.pagewalkthrough-1.1.0.js') }}"></script>
	<script src="{{ asset('assets/js/settings.pagewalkthrough.js') }}"></script>

	<div id="walkthrough">
		<div id="wt-step-0" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<!-- <div class="tooltip_arrow"></div> -->
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Hello, New User
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Welcome to the walkthrough!</p>
					<p class='tooltip_body_text'>We will guide you through all the features of the dashboard, and show you how it works.</p>
					<p class='tooltip_body_text tooltip_body_message'>Notice that the service is in BETA.  For this period, the service is FREE of charge!</p></div>
				<div class="tooltip_container_footer">
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-1" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Start Checking A Site
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Would you like to check a website?</p>
					<p class='tooltip_body_text'>You can start checking the uptime of any site by clicking the 'Add Site' button. <br><br>A helpful wizard will guide you in adding a site a step at a time.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-2" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Site Status
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>The sites you added appear here.</p>
					<div class='tooltip_body_list'>
						<div class='list_term'>Header</div>
						<div class='list_definition'>a group of checks for a site</div>
					</div>
					<div class='tooltip_body_list'>
						<div class='list_term'>Check</div>
						<div class='list_definition'>short name of url (hover for full link) and bar chart with uptime stats.  Green is good.  Red is bad.</div>
					</div>
					<div class='tooltip_body_list'>
						<div class='list_term'>See Details</div>
						<div class='list_definition'>click this link to see details</div>
					</div>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-3" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Recently Listed Site	
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Recently added site without data</p>
					<p class='tooltip_body_text'>Sites that have just been added will require an hour before graphs will start appearing.</p>
					<p class='tooltip_body_text'>We will display 'Data Not Available' while we are collecting data during this hour.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-4" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Fix It	
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Fixing your slow site is easy</p>
					<p class='tooltip_body_text'>If your site availability or response speed is slow then graph will turn red.</p>
					<p class='tooltip_body_text'>Don't worry you can fix this by simply clicking 'Fix It' button to get in contact with our uptime specialists.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="see_details" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-5" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Site Details	
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>After you click on the 'More Details' link...</p>
					<p class='tooltip_body_text'>You can see advanced statistical graphs, edit, suspend, and delete the check.</p>
					<p class='tooltip_body_text'>To close this details and go back to Dashboard, use the 'X' button.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-6" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Check Navigation	
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Access different check details</p>
					<p class='tooltip_body_text'>You can easily access different check details by clicking on it or using navigation arrows at the both ends.</p>
					<p class='tooltip_body_text'>You can also see full link by hover on check name.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-7" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Uptime Bar
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>See whether your site is up or down</p>
					<p class='tooltip_body_text'>Here you can see uptime (green) and downtime (red). Data will be displayed based on selection.</p>
					<p class='tooltip_body_text'>You can select data for day, week, month or months.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-8" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Detailed Graphs
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>See different statistics about the check</p>
					<p class='tooltip_body_text'>You can find different details about selected check like availability, downtime, response time and responsiveness by navigating between tabs.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="tooltip_next" href="javascript:;">Ok got it! <b>Next&#9656</b></a>
				</div>
			</div>
		</div>
		<div id="wt-step-9" class="tooltip_container_wrapper">
			<div class="tooltip_container">
				<div class="tooltip_arrow"></div>
				<a class="tooltip_close" href="{{ URL::route('dashboard') }}"></a>
				<div class="tooltip_container_header">
					<div class="tooltip_icon"></div>
					<div class="tooltip_title">
						Notification Emails
					</div>
				</div>
				<div class="tooltip_container_body">
					<p class='tooltip_body_title'>Notification emails list for check</p>
					<p class='tooltip_body_text'>You can see list of notification emails for current viewing check.</p>
					<p class='tooltip_body_text'>You can add or remove notification emails by using edit button.</p>
				</div>
				<div class="tooltip_container_footer">
					<a class="tooltip_prev" href="javascript:;">Back</a>
					<a class="close_step" href="{{ URL::route('dashboard') }}">Ok got it! <b>Finish</b></a>
				</div>
			</div>
		</div>		
	</div>
@stop