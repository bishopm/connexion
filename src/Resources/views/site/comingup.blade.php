@extends('connexion::templates.frontend')

@section('title','Coming up')

@section('content')
<div class="container">
	<div class="col-md-9 top30">
		<h1>Coming up at {{$setting['site_abbreviation']}}</h1>
		@forelse ($events as $key=>$category)
			<div class="row">
				@if ($key<>"ZZZZ")
					<div class="col-xs-12">{{$key}}</div>
				@else
					<hr>
				@endif
			</div>
			@foreach ($category as $event)
				<div class="row">
					<div class="col-xs-3"><a href="{{url('/')}}/group/{{$event->slug}}">{{$event->groupname}}</a></div>
					<div class="col-xs-9">{{$event->description}}</div>
				</div>
			@endforeach
		@empty
			No events are set up to be published on the site yet.
		@endforelse
	</div>
	<div class="col-md-3 top30">
		@if (count($blogs))
	  		<h3>Related blog posts</h3>
	  		<ul class="list-unstyled">
		  		@foreach ($blogs as $blog)
			    	<li>{{date("d M",strtotime($blog->created_at))}} <a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></li>
			    @endforeach
			</ul>
		@endif
	</div>
</div>
@endsection