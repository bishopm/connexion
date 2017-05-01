@extends('connexion::templates.webpage')

@section('content')
<div class="container">
	<div class="row">
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
							}
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
				<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to view group members</p>
			@endif
			</ul>
		</div>
		<div class="col-md-6">
			<div id="map_canvas" class="top10" style="height:250px;"></div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
<script src="{{url('/')}}/vendor/bishopm/js/mapsinglepoint.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    google.maps.event.addDomListener(window, 'load', initialize(11,{{$group->latitude}},{{$group->longitude}}));
  });
})(jQuery);
</script>
@endsection