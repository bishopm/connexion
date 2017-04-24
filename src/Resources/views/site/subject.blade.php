@extends('connexion::templates.webpage')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
		  	<h3>Content tagged '{{$tag}}'</h3>
		</div>
	    @if (count($blogs))
	    	<div class="col-md-4">
			    <h4>Blog posts (News/Article)</h4>
			    <ul class="list-unstyled">
				    @foreach ($blogs as $blog)
				    	<li><a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></li>
				    @endforeach
				</ul>
			</div>
		@endif
	    @if (count($sermons))
	    	<div class="col-md-4">
			    <h4>Sermons</h4>
			    <ul class="list-unstyled">
				    @foreach ($sermons as $sermon)
				    	<li><a href="{{url('/')}}/sermons/{{$sermon->series->slug}}/{{$sermon->slug}}">{{$sermon->title}}</a></li>
				    @endforeach
				</ul>
			</div>
		@endif
		@if (count($books))
			<div class="col-md-4">
			    <h4>Books</h4>
			    <ul class="list-unstyled">
				    @foreach ($books as $book)
				    	<li><a href="{{url('/')}}/book/{{$book->slug}}">{{$book->title}}</a></li>
				    @endforeach
				</ul>
			</div>
		@endif
	</div>
</div>
@endsection