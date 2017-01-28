@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
	    <h3>{{$person->firstname}} {{$person->surname}}</h3>
	    <img src="{{$person->getMedia('image')->first()->getUrl()}}">
	  </div>
	  <div class="col-md-3">
	    {{dd($person)}}
	  </div>
	</div>
</div>
@endsection