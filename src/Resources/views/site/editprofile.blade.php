@extends('connexion::templates.webpage')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	@if ((Auth::check()) and ($individual->user->id==Auth::user()->id))
		<h4>{{$individual->firstname}} {{$individual->surname}}</h4>
	  	@include('connexion::shared.errors')
	    {!! Form::open(['route' => array('admin.users.update',$individual->user->id), 'method' => 'put','files'=>'true']) !!}
	    {{ Form::bsHidden('name',$individual->user->name) }}
	    {{ Form::bsHidden('profile','true') }}
	    {{ Form::bsHidden('email',$individual->user->email) }}
		<ul class="nav nav-tabs" role="tablist">
	    	<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">User profile</a></li>
	    	<li role="presentation"><a href="#advanced" aria-controls="advanced" role="tab" data-toggle="tab">Advanced</a></li>
		</ul>
		<div class="tab-content">
	    	<div role="tabpanel" class="tab-pane active" id="profile"><br>
				{{ Form::bsText('bio','Say a little about yourself (optional)','Brief bio',$individual->user->bio) }}
			    <div class="form-group">
					<label for="service_id" class="control-label">Which service do you usually attend?</label>
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
				{{ Form::bsHidden('image',$individual->image) }}
				<div id="thumbdiv" style="margin-bottom:5px;"></div>
				<div id="filediv"></div>
	    	</div>
	    	<div role="tabpanel" class="tab-pane" id="advanced"><br>
				{{ Form::bsText('slack_username','Slack username (optional)','Email us for Slack access',$individual->user->slack_username) }}
				{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack'),$individual->user->notification_channel) }}
				{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No'),$individual->user->allow_messages) }}
	    	</div>
		</div>
		{{ Form::pgButtons('Update',route('admin.users.show',$individual->user->id)) }}
		{!! Form::close() !!}
		@include('connexion::shared.filemanager-modal',['folder'=>'individuals/' . $individual->id])
	@else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to edit {{$individual->firstname}}'s user profile</p>
	@endif
</div>
@endsection

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $("#removeMedia").on('click',function(e){
        e.preventDefault();
        $.ajax({
            type : 'GET',
            url : '{{url('/')}}/admin/individuals/<?php echo $individual->id;?>/removemedia',
            success: function(){
              $('#thumbdiv').hide();
              $('#filediv').show();
            }
        });
    });
    @include('connexion::shared.filemanager-modal-script',['folder'=>'individuals/' . $individual->id])
</script>
@endsection