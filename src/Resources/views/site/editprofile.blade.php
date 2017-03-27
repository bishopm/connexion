@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	@include('connexion::shared.errors') 
	<div class="row top30">
	  @if ((Auth::check()) and ($individual->user->id==Auth::user()->id))
	  	<h4>{{$individual->firstname}} {{$individual->surname}}</h4>
	  	@include('connexion::shared.errors')
	    {!! Form::open(['route' => array('admin.users.update',$individual->user->id), 'method' => 'put','files'=>'true']) !!}
	    {{ Form::bsHidden('name',$individual->user->name) }}
	    {{ Form::bsHidden('email',$individual->user->email) }}
	    {{ Form::bsText('bio','Say a little about yourself (optional)','Brief bio',$individual->user->bio) }}
	    <div class="form-group">
			<label for="service_id" class="control-label">Which service do you usually attend</label>
			<select name="service_id" id="service_id" class="form-control">
				@foreach ($society as $soc)
					@foreach ($soc->services as $service)
						@if ($individual->service_id==$service->id)
							<option selected value="{{$service->id}}">
						@else
							<option value="{{$service->id}}">
						@endif
							{{$service->society->society}} {{$service->servicetime}}
						</option>
					@endforeach
				@endforeach
			</select>
		</div>
		@if (!count($individual->getMedia('image')->first()))
			{{ Form::bsFile('image') }}
		@else
			<div id="thumbdiv">
				{{ Form::bsThumbnail($individual->getMedia('image')->first()->getUrl(),120,'Image') }}
			</div>
			<div id="filediv" style="display:none;">
				{{ Form::bsFile('image') }}
			</div>
		@endif
	    {{ Form::pgButtons('Update',route('admin.users.show',$individual->user->id)) }}
	    {!! Form::close() !!}
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to edit {{$individual->firstname}}'s user profile</p>
	  @endif
	</div>
</div>
@endsection