@extends('connexion::templates.frontend')

@section('content')  
    <div class="container top30">
    	<h1>Error - page not found</h1>
    	<p>Sorry! This page does not exist or the link has expired. Click <a href="{{url('/')}}">here</a> to go back to the home page.</p>
    </div>
@stop