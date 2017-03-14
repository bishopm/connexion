@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-4">
	    <img src="{{$person->getMedia('image')->first()->getUrl()}}" class="img-circle img-thumbnail">
	  </div>
	  <div class="col-md-8">
	    <h3 class="text-center">{{$person->firstname}} {{$person->surname}}</h3>
	    <div class="col-md-6">
	    	<h4 class="text-center">Sermons</h4>
	    </div>
	    <div class="col-md-6">
	    	<h4 class="text-center">Blogs</h4>
	    </div>
	  </div>
	</div>
</div>
@endsection