@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-4">
	    <img src="{{$user->individual->getMedia('image')->first()->getUrl()}}" class="img-circle img-thumbnail">
	  </div>
	  <div class="col-md-4">
	    <h3>{{$user->individual->firstname}} {{$user->individual->surname}}</h3>
	    Bio: {{$user->bio}}
	  </div>
	  <div class="col-md-4">
	  	<h4>Groups</h4>
	    @foreach ($user->individual->groups as $group)
	    	<li>{{$group->groupname}}</li>
	    @endforeach
	  </div>
	</div>
</div>
@endsection