@extends('connexion::templates.webpage')

@section('content')
<div class="container">
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
				<div class="col-xs-3"><a href="{{url('/')}}/group/{{$group->slug}}">{{$group->groupname}}</a></div>
				<div class="col-xs-9">{{$group->description}}</div>
			</div>
		@endforeach
	@empty
		No groups are set up to be published on the site yet.
	@endforelse
</div>
@endsection