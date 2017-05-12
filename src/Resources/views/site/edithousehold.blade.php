@extends('connexion::templates.frontend')

@section('content')
<div class="container">
	<div class="row top30">
	  @if (Auth::check())
	  	<h4>{{$household->addressee}}</h4>
	  	@include('connexion::shared.errors')
	    {!! Form::open(['route' => array('admin.households.update',$household->id), 'method' => 'put']) !!}
	    @include('connexion::households.partials.edit-fields')
	    {{ Form::bsText('sortsurname','Sort by (Household Surname)','Sort by (Household Surname)',$household->sortsurname) }}
	    {{ Form::pgButtons('Update',route('mydetails')) }}
	    {!! Form::close() !!}
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to edit {{$household->addressee}}'s details</p>
	  @endif
	</div>
</div>
@endsection