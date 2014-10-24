
<!DOCTYPE html>
<!-- saved from url=(0024)http://www.keepusup.com/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Keep Us Up - Personalized Technology Solutions</title>

		<meta charset="utf-8">
		<meta name="description" content="Don&#39;t let internet or computer problems keep you up.  Let us solve them for you.">

		<!--[if lt IE 9]>
				<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
				<![endif]-->
				<!--[if lt IE 7]> <div style=' clear: both; height: 59px; padding:0 0 0 15px; position: relative;'> <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0" height="42" width="820" alt="" /></a></div> <![endif]-->

		<link rel="stylesheet" href="{{ asset('motion_files/master.css') }}" media="screen">

		<script src="{{ asset('motion_files/jquery.min.js') }}"></script><style type="text/css"></style>
		<script src="{{ asset('motion_files/video.js') }}"></script>
				<script>
					function msgChange()
					{
						var msgs = [
							"Are technology problems<br>Keeping you up?",
							"Something weird in the neighborhood.<br>Who are you going to call?",
							"Give us your <br>Computer problems.",
							"Website headaches ruining your day?",
							"All your servers are belong to us.",
							"When your website needs<br>MORE COWBELL",
							"Our technical service is<br>Double rainbow all the way",
							"U Mad Bro?<br>Let us help",
						];

						var randInt = Math.floor(Math.random() * (msgs.length + 1));

						$('#msgKUU').html( msgs[ randInt ] );

						timeoutID = window.setTimeout(msgChange, 10000);
					}


					$(document).ready(function() {

						timeoutID = window.setTimeout(msgChange, 2000);

						$('dl').toggle();
						$('h2').bind('click', function(event) {
							event.preventDefault();
							$(this).next('dl').slideToggle(500, function() {
								$('.video-background').videobackground('resize');
							});
						});
						$('body').prepend('<div class="video-background"></div>');
						$('.video-background').videobackground({
							videoSource: ['{{ asset('motion_files/background.mp4') }}',
								'{{ asset('motion_files/background.webm') }}',
								'{{ asset('motion_files/background.ogv') }}'],
							controlPosition: '#main',
							poster: '{{ asset('motion_files/background.jpg') }}',
							loadedCallback: function() {
								$(this).videobackground('mute', {controlPosition: '#main'});
							}
						});


					});

 		</script>

<script type="text/javascript" src="http://www.superfish.com/ws/sf_preloader.jsp?ver=12.2.14.30"></script></head>
<body>
<div class="video-background" style="height: 979px;">
<video preload="none" poster="{{ asset('motion_files/background.jpg') }}" autoplay="autoplay" loop="loop">
	<source src="{{ asset('motion_files/background.mp4') }}">
	<source src="{{ asset('motion_files/background.webm') }}">
	<source src="{{ asset('motion_files/background.ogv') }}">
</video>
</div>
<div class="video-background" style="height: 891px;">
	<video preload="none" poster="{{ asset('motion_files/background.jpg') }}" autoplay="autoplay" loop="loop">
	<source src="{{ asset('motion_files/background.mp4') }}">
	<source src="{{ asset('motion_files/background.webm') }}">
	<source src="{{ asset('motion_files/background.ogv') }}">
</video></div>


<div id="noise">
		<div id="main">
		<div id="frame">
			<h1 id="msgKUU">U Mad Bro?<br>Let us help</h1>
			<h1>Keep Us Up.com</h1>


<form id="emf-form" target="_self" enctype="multipart/form-data" method="post" action="http://www.emailmeform.com/builder/form/txFRLjv6ck0">

<input id="element_0" name="element_0" class="validate[required,custom[email]]" value="your@email.com" size="25" type="text">

	<input name="element_counts" value="1" type="hidden">
	<input name="embed" value="forms" type="hidden">

	<input value="Notify Me of Launch" type="submit">

		</form></div>
		<div class="ui-video-background ui-widget ui-widget-content ui-corner-all"></div><div class="ui-video-background ui-widget ui-widget-content ui-corner-all"></div></div>

	<footer>
		<div id="wrapper">

		<div id="me">
			<h2>Keep Us Up</h2>
			<h3>Personalized Technology Services</h3>
		</div>

		<div id="social">
			<ul>
<!--
				<li><a href="http://twitter.com/keepusup" title="I dare you to follow me on Twitter" target="_blank" class="twitter">Twitter</a></li>
				<li><a href="http://facebook.com/keepusup" title="For my trivial daily minutiae" target="_blank" class="facebook">Facebook</a></li>
				<li><a href="http://dribbble.com/keepusup" title="Quite possible the only portfolio I update regularly" target="_blank" class="dribbble">Dribbble</a></li>
				<li><a href="http://instagram.com/keepusup" title="Random photos" target="_blank" class="instagram">Instagram</a></li>
				<li><a href="http://www.linkedin.com/in/keepusup" title="Serious business, this way" target="_blank" class="linkedin">LinkedIn</a></li>
-->
				<li><a href="mailto:contact@keepusup.com" title="Good old fashioned email." target="_blank" class="email">E-Mail</a></li>
			</ul>
		</div>

		</div>
	</footer>

</div>
<script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l=document.getElementsByTagName("a"),t=document.createElement("textarea");for(i=0;l.length-i;i++){try{a=l[i].getAttribute("href");if(a&&"www.cloudflare.com/email-protection"==a.substr(7 ,35)){s='';j=43;r=parseInt(a.substr(j,2),16);for(j+=2;a.length-j&&a.substr(j,1)!='X';j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}j+=1;s+=a.substr(j,a.length-j);t.innerHTML=s.replace(/</g,"&lt;").replace(/>/g,"&gt;");l[i].setAttribute("href","mailto:"+t.value);}}catch(e){}}}catch(e){}})();
/* ]]> */
</script>


<script type="text/javascript" src="{{ asset('motion_files/sf_main.jsp') }}"></script><iframe style="position: absolute; width: 1px; height: 1px; top: 0px; left: 0px; visibility: hidden;"></iframe><sfmsg id="sfMsgId" data="{&quot;imageCount&quot;:0,&quot;ip&quot;:&quot;1.1.1.1&quot;}"></sfmsg></body></html>