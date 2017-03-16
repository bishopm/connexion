@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row top30">
	  @if (isset($currentUser))
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
			    	@if (!$loop->last)
			    		, 
			    	@endif
			    @endif
		    @endforeach
		    @if ((count($user->individual->sermons)) or (count($user->individual->blogs)))
		       	<a class="btn btn-primary top10" href="{{url('/')}}/people/{{$user->individual->slug}}">View {{$user->individual->firstname}}'s blogs/sermons</a>
		    @endif
		  </div>
		  <div class="col-md-3">
		  	<h4>Recent comments</h4>
		  	<ul class="list-unstyled">
		  	@foreach ($recentcomments as $comment)
		  		@if (strpos($comment->commentable_type,'Sermon'))
		  			<li>{{date("d M",strtotime($comment->created_at))}} (sermon) - <a href="{{url('/')}}/sermons/{{$comment->commentable->series->slug}}/{{$comment->commentable->slug}}">{{$comment->commentable->sermon}}</a></li>
		  		@elseif (strpos($comment->commentable_type,'Blog'))
					<li>{{date("d M",strtotime($comment->created_at))}} (blog) - <a href="{{url('/')}}/blog/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>
		  		@elseif (strpos($comment->commentable_type,'Resource'))
					<li>{{date("d M",strtotime($comment->created_at))}} (course) - <a href="{{url('/')}}/course/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>
		  		@endif
		  	@endforeach
		  	</ul>
		  </div>
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to view {{$user->individual->firstname}}'s user profile</p>
	  @endif
	</div>
</div>
@endsection