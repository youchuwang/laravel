<div class="page-sidebar nav-collapse collapse">
	<div class="note-book-stle">
		<h2>Would you like to check another site?</h2>
		<p>Kickstart your uptime with our fast and reliable service.</p>
		<a href="#" class="open_inner_page btn green" main_id="dashboard" modal_id="contact-support-add-another-site">Add Another Site</a>
	</div>
	<div class="alert-sidebar">
		<div><h5>Your Alerts will be sent to:</h5></div>
		<div>
			<a href="mailTo:{{ $useremail }}" class="sidebar-email">{{ $useremail }}</a>
			<p></p>
			@foreach ($usealertemail as $item)
			@if( $item->activated == 1 )
			<a href="mailTo:{{ $item->alertemail }}" class="sidebar-email">{{ $item->alertemail }}</a>
			<p></p>
			@endif
			@endforeach
		</div>
		<div><a href="{{ URL::route('account') }}" class="change-setting">Change Settings</a></div>
	</div>
</div>