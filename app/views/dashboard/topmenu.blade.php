<div id="main-header-hav">
	<div class="beta-container">
		<div class="row-fluid">
			<div class="span12">
				<!-- BEGIN LOGO -->
				<a  class="brand" href="{{ URL::route('dashboard') }}"><img src="assets/img/logo.png" alt="logo" /></a>
				<!-- END LOGO -->
			
				<div class="navbar navbar-inverse header-menu" style="display: inline;">
	            <div class="navbar-inner">
	                <div class="container"> 
	                    <ul class="nav">
	                        <li><a href="{{ URL::route('dashboard') }}">Dashboard</a></li>

	                        <li class="parent-menu-item subitem-left">
								<a href="{{ URL::route('account') }}">Account</a>
	                            <ul>
	                                <li><a href="{{ URL::route('account') }}">Account Settings</a></li>
	                                <li><a href="{{ URL::route('logout') }}">Log Out</a></li>
	                            </ul>
	                        </li>

	                        <li class="parent-menu-item subitem-right">
								<a href="{{ URL::route('contact-support') }}">Help</a>
	                            <ul>
	                                <li><a href="{{ URL::route('walkthrough') }}">Walkthrough</a></li>
	                                <li><a href="{{ URL::route('contact-support') }}">Contact Support</a></li>
	                            </ul>
	                        </li>
	    
	                    </ul>
	                </div>
	            </div>
	        </div>
			</div>

			

		</div>
	</div>
</div>