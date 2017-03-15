@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row top30">
	  <div class="col-md-3">
	    <img src="{{$user->individual->getMedia('image')->first()->getUrl()}}" class="img-circle img-thumbnail">
	  </div>
	  <div class="col-md-3">
	    <h3>{{$user->individual->firstname}} {{$user->individual->surname}}</h3>
	    Bio: {{$user->bio}}
	  </div>
	  <div class="col-md-3">
	  	<h4>Groups</h4>
	    @foreach ($user->individual->groups as $group)
	    	@if ($group->publish)
		    	<a href="{{url('/')}}/groups/{{$group->slug}}">{{$group->groupname}}</a>
		    @endif
	    @endforeach
	  </div>
	  <div class="col-md-3">
	  	<h4>Recent activity</h4>
	  	<ul class="list-unstyled">
	  	@foreach ($user->comments as $comment)
	  		<li>{{date("d M",strtotime($comment->commentable->created_at))}} - commented on <a href="{{url('/')}}">{{$comment->commentable->title}}</a></li>
	  	@endforeach
	  	</ul>
	  </div>
	</div>
</div>
@endsection