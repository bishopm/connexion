@extends('connexion::templates.frontend')

@section('title',$blog->title)
@section('page_image',url('/') . '/storage/individuals/' . $blog->individual->id . '/' . $blog->individual->image)
@section('page_description', strip_tags($blog->body))

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
@stop

@section('content')
<div class="container mt-3">
	<div class="row">
	  	<div class="col-md-9">
			<h3>{{$blog->title}}</h3>
			<a href="{{url('/')}}/people/{{$blog->individual->slug}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a>&nbsp;{{date("d M Y",strtotime($blog->created_at))}}
		  	@foreach ($blog->tags as $tag)
		  		<a class="badge badge-primary" href="{{url('/')}}/subject/{{$tag->slug}}">{{$tag->name}}</a></b>&nbsp;
		  	@endforeach
		  	@if (count($media))
		  		<img style="float:left; margin-right:15px;" src="{{$blog->getMedia('image')->first()->getUrl()}}">
			@endif
			{!!$blog->body!!}
  	    	@include('connexion::shared.comments')
  	  	</div>
	  	<div class="col-md-3">
	  		<h3>Explore by subject</h3>
	  		{!!$cloud->render()!!}
	  	</div>
	</div>
</div>
@endsection

@section('js')
  @include('connexion::shared.commentsjs', ['url' => route('admin.blogs.addcomment',$blog->id)])
@endsection