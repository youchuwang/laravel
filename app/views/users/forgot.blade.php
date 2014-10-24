@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Body Class --}}
@section('body_class')
@parent
login
@stop

{{-- Content --}}
@section('content')

<div class="content">

        {{ Form::open(array('action' => 'UserController@forgot', 'method' => 'post', 'class' => 'form-vertical')) }}
            
			<h3 class="">Forget Password ?</h3>
            
			<p>Enter your e-mail address below to reset your password.</p>
			
			<div class="control-group">
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-envelope-alt"></i>
						{{ Form::text('email', null, array('class' => 'm-wrap', 'placeholder' => 'E-mail', 'autofocus')) }}
					</div>
				</div>
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
			</div>

			<div class="form-actions">
				<a href="{{ URL::route('home') }}" id="back-btn" class="btn">
					<i class="m-icon-swapleft"></i>  Back
				</a>
				<button type="submit" id="login-btn" class="btn green pull-right">
					Send Instructions <i class="m-icon-swapright m-icon-white"></i>
				</button>				
			</div>
  		{{ Form::close() }}

</div>

@stop