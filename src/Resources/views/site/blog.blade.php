@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
	  <h3>{{$blog->title}} <small>{{$blog->individual->firstname}} {{$blog->individual->surname}}</small></h3>
	  @foreach ($blog->tags as $tag)
	  	<a class="btn btn-primary" href="{{url('/')}}/subject/{{$tag->name}}">{{$tag->name}}</a></b>&nbsp;
	  @endforeach
	  <br>
	  {{$blog->body}}
	  </div>
	  <div class="col-md-3">
	  <h3>Other tags</h3>
	  </div>
	</div>
</div>
@endsection