@extends('connexion::templates.frontend')

@section('title','Event details: ' . $event->groupname)

@section('content')
<div class="container">
	<div class="row">
		@if ($event->publish)
			<div class="col-md-6">
				<h3>{{$event->groupname}}
				@include('connexion::shared.errors') 
				@if (Auth::check())
					<a href="{{url('/')}}/event/{{$event->slug}}/sign-up" class="btn btn-primary btn-xs">Sign me up!</a>
				@endif
				</h3>
				<h4>{{date("d M Y H:i",$event->eventdatetime)}}</h4>
				@if ($event->image)
					<img width="100px" style="float-left;" src="{{url('/')}}/public/storage/events/{{$event->image}}">
				@endif
				{{$event->description}}
			</div>
			@if (Auth::check())
				<div class="col-md-6 top50">
					<div id="map_canvas" class="top10" style="height:250px;"></div>
				</div>
			@endif
			<div class="col-md-6 top10">
				@if (Auth::check())
					<h4>Signed up already</h4>
					<ul class="list-unstyled">
						@forelse ($event->individuals as $indiv)
							@if (isset($indiv->user))
								<li><a href="{{url('/')}}/users/{{$indiv->slug}}">{{$indiv->firstname}} {{$indiv->surname}}</a></li>
							@else
								<li>{{$indiv->firstname}} {{$indiv->surname}}</li>
							@endif
						@empty
							You'll be the first to sign up!
						@endforelse
					</ul>
				@else
					<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to sign up and see who else will be there</p>
				@endif
			</div>
			<div class="col-md-6 top10 text-right">
				@if ($payment)
					<img src="{{$payment}}">
				@endif
			</div>
		@else
			<p class="top20">This event is not configured to be published on the site. Contact us if you think it should be.</p>
		@endif
	</div>
</div>
@endsection

@section('js')
@parent
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
@if (Auth::check())
	<script src="{{url('/')}}/public/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
	<script type="text/javascript">
	(function ($) {
	  jQuery(window).on('load', function() {
	    google.maps.event.addDomListener(window, 'load', showMap(13,{{$event->latitude}},{{$event->longitude}}));
	  });
	})(jQuery);
	</script>
@endif
@endsection