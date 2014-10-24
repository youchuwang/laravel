@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Body Class --}}
@section('body_class')
@parent
login
@stop

{{-- Content --}}
@section('content')

<div class="content">
    
        {{ Form::open(array('action' => 'UserController@resend', 'method' => 'post')) }}
        	
            <h3 class="">Resend Activation Email</h3>
    		
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
				<button type="submit" id="login-btn" class="btn green pull-right">
					Resend <i class="m-icon-swapright m-icon-white"></i>
				</button>				
			</div>
			
        {{ Form::close() }}
    
</div>

@stop
