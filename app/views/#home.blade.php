@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('pages.site_title')}}
@stop

{{-- Body Class --}}
@section('body_class')
@parent
{{ '' }}
@stop

{{-- Content --}}
@section('content')

<!-- Container -->
<div class="container">

@if (Sentry::check() )
	<div class="panel panel-success">
		 <div class="panel-heading">
			<h3 class="panel-title"><span class="glyphicon glyphicon-ok"></span> {{trans('pages.loginstatus')}}</h3>
		</div>
		<div class="panel-body">
			<p><strong>{{trans('pages.sessiondata')}}:</strong></p>
			<pre>{{ var_dump(Session::all()) }}</pre>
		</div>
	</div>
@endif 

</div>
<!-- ./ container -->

@stop