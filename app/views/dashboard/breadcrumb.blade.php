<div class="row-fluid">
	<div class="span12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
		<ul class="breadcrumb">
			<li>
				<a href="{{ URL::route('dashboard') }}">Dashboard</a> &gt;
			</li>
			<li><a href="{{ URL::route($page_slug) }}">{{ $page_name }}</a></li>
			<li class="breadcrumb-date">
				<div id="dashboard-report-range" class="dashboard-date-range" style="display: block;">
					<span><?php echo date('F d, Y', time()); ?></span>
				</div>
			</li>
		</ul>
		<div class="dashboard-admin-notice">
			<img src="assets/img/dashboard-admin.png"/>
			<div class="dashboard-admin-notice-content">
				<p>Good Morning Robert!</p>
				<h3 class="page-title">
					Dashboard
				</h3>
			</div>
		</div>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>