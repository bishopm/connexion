@extends('connexion::templates.frontend')

@section('title','Blog post: ' . $blog->title)
@section('page_image',url('/') . '/public/storage/individuals/' . $blog->individual->id . '/' . $blog->individual->image)
@section('page_description', $blog->body)

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/public/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="container">
	<div class="row">
	  	<div class="col-md-9">
			<h3>{{$blog->title}}</h3>
			<a href="{{url('/')}}/people/{{$blog->individual->slug}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a>&nbsp;{{date("d M Y",strtotime($blog->created_at))}}
		  	@foreach ($blog->tags as $tag)
		  		<a class="label label-default" href="{{url('/')}}/subject/{{$tag->slug}}">{{$tag->name}}</a></b>&nbsp;
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