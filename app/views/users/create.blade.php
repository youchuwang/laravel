@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Signup
@stop

{{-- Body Class --}}
@section('body_class')
@parent
login
@stop

{{-- Content --}}
@section('content')

<div class="content">

	{{ Form::open(array('action' => 'UserController@store', 'class' => 'form-vertical login-form')) }}

		<h3 class="form-title">Create account</h3>
		
		<div class="control-group">
			<div class="controls">
				<div class="input-icon left">
					<i class="icon-envelope-alt"></i>
					{{ Form::text('email', null, array('class' => 'm-wrap', 'placeholder' => 'E-mail')) }}
				</div>
				{{ ($errors->has('email') ? $errors->first('email') : '') }}
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<div class="input-icon left">
					<i class="icon-lock"></i>
					{{ Form::password('password', array('class' => 'm-wrap', 'placeholder' => 'Password')) }}
				</div>
			</div>
			{{ ($errors->has('password') ?  $errors->first('password') : '') }}
		</div>
		
		<div class="control-group">
			<div class="controls">
				<div class="input-icon left">
					<i class="icon-lock"></i>
					{{ Form::password('password_confirmation', array('class' => 'm-wrap', 'placeholder' => 'Confirm Password')) }}
				</div>
			</div>
			{{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
		</div>
		
		<div class="form-actions">
			<div class="clearfix"></div>
			<a href="{{ URL::route('home') }}" id="back-btn" class="btn pull-left">
				<i class="m-icon-swapleft m-icon-black"></i> Back
			</a>
			<button type="submit" id="login-btn" class="btn green pull-right">
				Create account <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	{{ Form::close() }}

</div>

@stop