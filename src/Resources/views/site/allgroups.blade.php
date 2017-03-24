@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<h1>{{$setting['site_abbreviation']}} Groups</h1>
	@foreach ($groups as $key=>$category)
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
	@endforeach
</div>
@endsection