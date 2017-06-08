@extends('connexion::templates.frontend')

@section('title','Lectionary readings')

@section('content')
<div class="container">
	<div class="col-md-12 top30">
        <h3>{!!$title!!}</h3>
        <h4>{{$readings}}</h4>
        <small>{!!$copyright!!}</small>
        <p>{!!$text!!}</p>
	</div>
</div>
@endsection