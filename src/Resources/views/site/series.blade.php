@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <h3>{{$series->series}}</h3>
	  <div class="col-md-6">
	    <img src="{{$series->getMedia('image')->first()->getUrl()}}">
	  </div>
	  <div class="col-md-6">
	  	  <table class="table table-responsive table-striped">
		      @foreach ($series->sermons as $sermon)
		      	  <tr><td>{{$sermon->servicedate}}</td><td><a href="{{route('websermon',array($series->slug,$sermon->slug))}}">{{$sermon->sermon}}</a></td><td>{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</td></tr>
		      @endforeach
		  </table>
	  </div>
	</div>
</div>
@endsection