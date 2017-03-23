@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  @if (isset($currentUser))
	  <h3>My details <small>{{$household->addressee}}</small></h3>
		{{$household}}  
	  @else 
	  	<h3>My details</h3>
        <p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see your profile details</p>
      @endif
	</div>
</div>
@endsection