@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
		  <h3>{{$blog->title}} <small><a href="{{url('/')}}/people/{{$blog->individual->slug}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a>&nbsp;
		  @foreach ($blog->tags as $tag)
		  	<a class="label label-primary" href="{{url('/')}}/subject/{{$tag->name}}">{{$tag->name}}</a></b>&nbsp;
		  @endforeach
		  </small></h3>
		  @if (count($media))
			  <div class="pull-left" style="margin-right:20px"><img class="img-responsive" src="{{$blog->getMedia('image')->first()->getUrl()}}"></div>
		  @endif
   		  <div class="pull-left">{!!$blog->body!!}</div>
   		  <div class="row">
   		  	<div class="col-md-12">
			  @include('connexion::shared.comments')
			</div>
		  </div>
	  </div>
	  <div class="col-md-3">
	  	<h3>Other tags</h3>
	  </div>
	</div>
</div>
@endsection

@section('js')
  @include('connexion::shared.commentsjs', ['url' => route('admin.blogs.addcomment',$blog->id)])
@endsection