@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <h3>My details <small>{{$household->addressee}}</small></h3>
	  {{$household}}
	</div>
</div>
@endsection