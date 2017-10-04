@extends('connexion::templates.frontend')

@section('title','Register as a user')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Register as a site user
			<small>These are the details we need to get you set up as a user</small></div></h3>
			<div class="alert">
			@include('connexion::shared.errors')
			</div>
			<div class="col-md-4">
				Welcome! You may be new to the church or a long-standing member who was not able to register because your details on our database were incomplete. Either way, we're excited to get you set up and using the site :)<br><br>Being a registered user of this website gives you access to information not available to the general public (nothing terribly personal - no contact details, usually just a name and photo - but still not details we want available to the world at large). Because of this, we can't automatically register you once you've completed this form. Instead, someone at the church office will need to look over your details (and possibly contact you) before registering you.<br><br>But once that is done, you'll get a mail from us and can then login, add details of other family members, sign up for groups, and start using the full website. You're also welcome to email or phone if you have any questions at all.
			</div>
			<div class="col-md-8">
				<form id="newuserform" autocomplete="off" method="post" action="{{route('admin.newuser')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				{{ Form::bsText('firstname','First name','First name') }}
				{{ Form::bsText('surname','Surname','Surname') }}
				<div class="form-group">
					<label for="name" class="control-label">Website username</label>
					<input class="form-control" id="name" name="name" type="text" placeholder="Choose a unique username" value="{{ old('name') }}">
					<div id="errmess" style="display:none;"><i class="fa fa-times"></i> Username is required and must be unique</div>
					<div id="okmess" style="display:none;"><i class="fa fa-check"></i> This username is available</div>
				</div>
				{{ Form::bsPassword('password','Password','Password') }}
				{{ Form::bsText('cellphone','Cellphone','Cellphone') }}
				{{ Form::bsText('email','Email','Email') }}
				{{ Form::bsSelect('sex','Sex',array('male','female')) }}
				{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev')) }}
				<div class="form-group">
					<label for="servicetime" class="control-label">Which service do you usually attend?</label>
					<select name="servicetime" id="servicetime" class="form-control">
						@foreach ($services as $service)
							<option value="{{$service}}">{{$service}}</option>
						@endforeach
					</select>
				</div>
				<button id="storeuser" type="button" class="btn btn-primary">Register</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
      });
      $('#storeuser').on('click',function(){
        $('#newuserform').submit();
      });      
      $('#name').bind('input', function(){
      	if ($('#name').val()!==''){
	      	usercheck($('#name').val());
	    } else {
	    	$('#errmess').show();
            $('#okmess').hide();
			$( "#storeuser" ).prop( "disabled", true );
	    }
      });
      function usercheck(username){
      	$.ajax({
            type : 'GET',
            url : '{{url('/')}}' + '/admin/newuser/checkname/' + username,
            success: function(e){
            	if (e=='error'){
            		$('#errmess').show();
            		$('#okmess').hide();
					$( "#storeuser" ).prop( "disabled", true );
            	} else {
					$('#errmess').hide();
            		$('#okmess').show();
            		$( "#storeuser" ).prop( "disabled", false );
            	}
            }
        });
      };
	</script>
@stop
