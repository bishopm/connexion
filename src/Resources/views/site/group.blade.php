@extends('connexion::templates.frontend')

@section('title','Group details: ' . $group->groupname)

@section('content')
<div class="container">
	<div class="row">
		@if ($group->publish)
		<div class="col-md-12">
			<h3>{{$group->groupname}}
			@include('connexion::shared.errors') 
			@if (count($signup))
				<a href="{{url('/')}}/course/{{$signup[0]->slug}}/sign-up" class="btn btn-primary btn-xs">Sign me up!</a>
			@endif
			</h3>
			{{$group->description}}
		</div>
		<div class="col-md-6">
			<h4>Group members</h4>
			<ul class="list-unstyled">
			@if (Auth::check())
				@if ((isset(Auth::user()->individual)) and (Auth::user()->individual->id==$group->leader))
					<a title="Only group leaders can see this button" class="btn btn-primary btn-xs" href="{{url('/')}}/group/{{$group->slug}}/edit">Edit this group</a>
				@else
					@if ($leader)
						To change group details, contact: 
						@if (null!==$leader->user)
							<a href="{{url('/')}}/users/{{$leader->slug}}">{{$leader->firstname}} {{$leader->surname}}</a>
						@else
							{{$leader->firstname}} {{$leader->surname}}
						@endif
					@else
						<b>No leader designated yet!</b>
					@endif
				@endif
				@foreach ($group->individuals as $indiv)
					@if (isset($indiv->user))
						<li><a href="{{url('/')}}/users/{{$indiv->slug}}">{{$indiv->firstname}} {{$indiv->surname}}</a></li>
					@else
						<li>{{$indiv->firstname}} {{$indiv->surname}}</li>
					@endif
				@endforeach
			@else
				<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button>
				@if ($group->grouptype=="fellowship") 
					to see who else is in the group and where they meet</p>
				@elseif ($group->grouptype=="service")
					to see who else serves on this team</p>
				@else
					to see who else has signed up</p>
				@endif
			@endif
			</ul>
		</div>
		@if (Auth::check())
			<div class="col-md-6">
				<div id="map_canvas" class="top10" style="height:250px;"></div>
			</div>
		@endif
		@else
			<p class="top20">This group is not configured to be published on the site. Contact us if you think it should be.</p>
		@endif
	</div>
</div>
@endsection

@section('js')
@parent
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
@if (Auth::check())
	<script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
	<script type="text/javascript">
	(function ($) {
	  jQuery(window).on('load', function() {
	    google.maps.event.addDomListener(window, 'load', showMap(13,{{$group->latitude}},{{$group->longitude}}));
	  });
	})(jQuery);
	</script>
@endif
@endsection