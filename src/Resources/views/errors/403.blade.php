@extends('connexion::templates.frontend')

@section('content')  
    <div class="container top30">
    	<h1>Error - unauthorised access</h1>
    	<p>Sorry - you're not authorised to see this page! Send us an {{ HTML::mailto($setting['church_email'], 'email') }} if you think you should be.</p>
    	<p>It may also just be that your login session has expired. If so, click <a href="{{url('/')}}/login">here</a> to log in again.</p>
    </div>
@stop