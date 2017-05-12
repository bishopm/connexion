@extends('connexion::templates.frontend')

@section('content')
<div class="container">
	<div class="row">
	  <div class="col-md-9 top30">
	    {!!$page->body!!}
	  </div>
	  <div class="col-md-3 top30">
	  	@if (count($blogs))
	  		<h3>Related blog posts</h3>
	  		<ul class="list-unstyled">
		  		@foreach ($blogs as $blog)
			    	<li>{{date("d M",strtotime($blog->created_at))}} <a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></li>
			    @endforeach
			</ul>
		@endif
	  </div>
	</div>
</div>
@endsection