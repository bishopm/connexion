@extends('connexion::templates.frontend')

@section('title','Coming up')

@section('content')
<div class="container">
	<div class="col-md-12 top30">
		@forelse ($events as $key=>$category)
			<div class="row">
				<div class="col-xs-12">
					<h1>Coming up at {{$setting['site_abbreviation']}}</h1>
				</div>
				<div class="col-xs-2"></div>
				<div class="col-xs-6"></div>
				<div class="col-xs-2"><b>Date & time</b></div>
				<div class="col-xs-2"><b>Signed up</b></div>
			</div>
			@foreach ($category as $event)
				<div class="row">
					<div class="col-xs-2"><a href="{{url('/')}}/coming-up/{{$event->slug}}">{{$event->groupname}}</a></div>
					<div class="col-xs-6">{{$event->description}}</div>
					<div class="col-xs-2">{{date("d M Y H:i",$event->eventdatetime)}}</div>
					<div class="col-xs-2">{{count($event->individuals)}}</div>
				</div>
			@endforeach
		@empty
			No upcoming events at the moment. Watch our Facebook page and website for announcements.
		@endforelse
	</div>
</div>
@endsection