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
				    	<li>{{date("Y-m-d",strtotime($blog->created_at))}} <a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a> <a href="{{url('/')}}/users/{{$blog->individual->slug}}"><i>{{$blog->individual->firstname}} {{$blog->individual->surname}}</i></a></li>
				    @endforeach
				</ul>
			</div>
		@endif
	    @if (count($sermons))
	    	<div class="col-md-4">
			    <h4>Sermons</h4>
			    <ul class="list-unstyled">
				    @foreach ($sermons as $sermon)
				    	<li>{{date("Y-m-d",strtotime($blog->created_at))}} <a href="{{url('/')}}/sermons/{{$sermon->series->slug}}/{{$sermon->slug}}">{{$sermon->title}}</a> <a href="{{url('/')}}/users/{{$sermon->individual->slug}}"><i>{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</i></a></li>
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