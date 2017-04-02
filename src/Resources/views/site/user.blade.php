@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row top30">
	  @if (Auth::check())
		  <div class="col-md-3">
		  	@if (count($user->individual->getMedia('image')))
                <img class="img-responsive img-circle img-thumbnail" src="{{$user->individual->getMedia('image')->first()->getUrl()}}">
            @else
                <img class="img-responsive img-circle img-thumbnail" src="{{asset('vendor/bishopm/images/profile.png')}}">
            @endif
		  </div>
		  <div class="col-md-3">
		    <h3>{{$user->individual->firstname}} {{$user->individual->surname}}</h3>
		    {{$user->bio}}
		    @if (Auth::user()->id == $user->id)
			    <p class="top10"><a href="{{url('/')}}/users/{{$user->individual->slug}}/edit" class="btn btn-xs btn-primary">Edit my public profile</a></p>
			@endif
		  </div>
		  <div class="col-md-3">
		  	<h4>Groups</h4>
		    @forelse ($user->individual->groups as $group)
		    	@if ($group->publish)
			    	<a href="{{url('/')}}/group/{{$group->slug}}">{{$group->groupname}}</a>
			    	@if (!$loop->last)
			    		, 
			    	@endif
			    @endif
			@empty
				No group memberships
		    @endforelse
		    @if ((count($user->individual->sermons)) or (count($user->individual->blogs)))
		       	<a class="btn btn-primary top10" href="{{url('/')}}/people/{{$user->individual->slug}}">View {{$user->individual->firstname}}'s blogs/sermons</a>
		    @endif
		    @if ((!$staff) and (isset($user->individual->service_id)))
				<h4>Usual Sunday service</h4>
				{{$user->individual->service->society->society}} {{$user->individual->service->servicetime}}
			@endif
		  </div>
		  <div class="col-md-3">
		  	<h4>Recent comments</h4>
		  	<ul class="list-unstyled">
		  	@foreach ($comments as $comment)
		  		@if (strpos($comment->commentable_type,'Sermon'))
		  			<li>{{date("d M",strtotime($comment->created_at))}} (sermon) - <a href="{{url('/')}}/sermons/{{$comment->commentable->series->slug}}/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>
		  		@elseif (strpos($comment->commentable_type,'Blog'))
					<li>{{date("d M",strtotime($comment->created_at))}} (blog) - <a href="{{url('/')}}/blog/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>
		  		@elseif (strpos($comment->commentable_type,'Course'))
					<li>{{date("d M",strtotime($comment->created_at))}} (course) - <a href="{{url('/')}}/course/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>
				@elseif (strpos($comment->commentable_type,'Book'))
					<li>{{date("d M",strtotime($comment->created_at))}} (book) - <a href="{{url('/')}}/book/{{$comment->commentable->slug}}">{{$comment->commentable->title}}</a></li>					
		  		@endif
		  	@endforeach
		  	</ul>
		  	{{ $comments->links() }}
		  </div>
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to view {{$user->individual->firstname}}'s user profile</p>
	  @endif
	</div>
</div>
@endsection