@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
	  	<h3>Content tagged '{{$tag}}'</h3>
	    @if (count($blogs))
		    <h4>Blog posts (News/Article)</h4>
		    <ul class="list-unstyled">
			    @foreach ($blogs as $blog)
			    	<li><a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></li>
			    @endforeach
			</ul>
		@endif
	    @if (count($sermons))
		    <h4>Sermons</h4>
		    <ul class="list-unstyled">
			    @foreach ($sermons as $sermon)
			    	<li>{{$sermon->title}}</li>
			    @endforeach
			</ul>
		@endif
		@if (count($books))
		    <h4>Books</h4>
		    <ul class="list-unstyled">
			    @foreach ($books as $book)
			    	<li><a href="{{url('/')}}/book/{{$book->slug}}">{{$book->title}}</a></li>
			    @endforeach
			</ul>
		@endif
	  <div class="col-md-3">
	  </div>
	</div>
</div>
@endsection