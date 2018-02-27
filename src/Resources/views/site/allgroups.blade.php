@extends('connexion::templates.frontend')

@section('title','Connect with a small group')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<h1>{{$setting['site_abbreviation']}} Groups</h1>
			@forelse ($groups as $key=>$category)
				<div class="row">
					@if ($key<>"ZZZZ")
						<div class="col-xs-12">{{$key}}</div>
					@else
						<hr>
					@endif
				</div>
				@foreach ($category as $group)
					<div class="row">
						<div class="col-3"><a href="{{url('/')}}/group/{{$group->slug}}">{{$group->groupname}}</a></div>
						<div class="col-9">{{$group->description}}</div>
					</div>
				@endforeach
			@empty
				No groups are set up to be published on the site yet.
			@endforelse
		</div>
		<div class="col-md-3">
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
</div>
@endsection