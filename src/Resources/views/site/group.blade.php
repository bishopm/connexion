@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	<h3>{{$group->groupname}}</h3>
	<ul class="list-unstyled">
	@foreach ($group->individuals as $indiv)
		<li><a href="{{url('/')}}/users/{{$indiv->slug}}">{{$indiv->firstname}} {{$indiv->surname}}</a></li>
	@endforeach
	</ul>
	</div>
</div>
@endsection