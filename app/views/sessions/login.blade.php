@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Body Class --}}
@section('body_class')
@parent
login
@stop

{{-- Content --}}
@section('content')

<!-- BEGIN LOGIN -->
<div class="content">
{{ Form::open(array('id' => 'login_form', 'action' => 'SessionController@store', 'class' => 'form-vertical login-form')) }}
	<h3 class="form-title">Login to your account</h3>
	
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-envelope-alt"></i>
				{{ Form::text('email', null, array('class' => 'm-wrap', 'placeholder' => 'Email', 'autofocus')) }}
			</div>
			{{ ($errors->has('email') ? $errors->first('email') : '') }}
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				{{ Form::password('password', array('class' => 'm-wrap', 'placeholder' => 'Password'))}}
			</div>
			{{ ($errors->has('password') ?  $errors->first('password') : '') }}
		</div>
	</div>
	<div class="form-actions">
		<label class="checkbox">
			{{ Form::checkbox('rememberMe', 'rememberMe') }} Keep me logged in
		</label>
		<div class="clearfix"></div>
		<p></p>
		<a href="{{ URL::route('home') }}" id="back-btn" class="btn pull-left">
			<i class="m-icon-swapleft m-icon-black"></i> Back
		</a>
		<button type="submit" id="login-btn" class="btn green pull-right">
			Log in <i class="m-icon-swapright m-icon-white"></i>
		</button>
	</div>
	<div class="forget-password">
		<h5>I don't have any account yet. <a href="{{ URL::route('register') }}">Sign up now</a></h5>
		<h5><a href="{{ route('forgotPasswordForm') }}" class="" id="forget-password">Forgot your password ?</a></h5>
	</div>
	<!--a class="btn btn-link" href="{{ route('forgotPasswordForm') }}">Forgot Password</a//-->
{{ Form::close() }}

</div>
<!-- END LOGIN -->

@stop
