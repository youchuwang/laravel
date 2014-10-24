@if ( $message = Session::get('success'))
<div class="alert alert-info">
	{{ $message }}
</div>
{{ Session::forget('success') }}
@endif

@if ( $message = Session::get('error'))
<div class="alert alert-info">
	{{ $message }}
</div>
{{ Session::forget('success') }}
@endif

@if ( $message = Session::get('duplicateemail'))
<div class="alert alert-error">
	{{ $message }}
</div>
{{ Session::forget('success') }}
@endif

@if ( $message = Session::get('incorrectconfirmpassword'))
<div class="alert">
	{{ $message }}
</div>
{{ Session::forget('success') }}
@endif