@extends('connexion::templates.frontend')

@section('title','Sermon series: ' . $series->title)

@section('content')
<div class="container">
	<div class="row">
	  	<h3>{{$series->title}}</h3>
	  	<div class="col-md-6">
	    	<img src="{{url('/')}}/storage/series/{{$series->image}}">
		</div>
		<div class="col-md-6">
			<p>{{$series->description}}</p>
		  	<table class="table table-responsive table-striped">
			    @forelse ($series->sermons as $sermon)
			     	<tr>
			     		<td>
			     			{{$sermon->servicedate}}
			     		</td>
			      	  	<td>
			      	  		<a href="{{route('websermon',array($series->slug,$sermon->slug))}}">{{$sermon->title}}</a>
			      	  	</td>
			      	  	<td>
			      	  		@if ($sermon->individual)
				      	  		<a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a>
				      	  	@else
				      	  		Guest preacher
				      	  	@endif
			      	  	</td>
			      	</tr>
			    @empty
			    	<tr><td>No sermons have been added to this series yet</td></tr>
			    @endforelse
			</table>
	  	</div>
	</div>
</div>
@endsection