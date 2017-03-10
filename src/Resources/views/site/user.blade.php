@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
	    <h3>{{$user->individual->firstname}} {{$user->individual->surname}}</h3>
	    <img src="{{$user->individual->getMedia('image')->first()->getUrl()}}">
	  </div>
	  <div class="col-md-3">
	    
	  </div>
	</div>
</div>
@endsection