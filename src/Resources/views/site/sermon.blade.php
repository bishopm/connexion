@extends('connexion::templates.frontend')

@section('title','Sermon: ' . $sermon->title)
@section('page_image',url('/') . '/public/storage/series/' . $sermon->series->image)
@section('page_description', $description)

@section('css')
<link href="{{ asset('/public/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
<meta id="token" name="token" value="{{ csrf_token() }}" />
<link href="{{ asset('/public/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4 text-center">
			<a title="View sermon series: {{$sermon->series->title}}" href="{{url('/')}}/sermons/{{$sermon->series->slug}}"><img class="top17" src="{{url('/')}}/public/storage/series/{{$sermon->series->image}}"></a>
    	    <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
          <div class="col-xs-12">{{date("j M", strtotime($sermon->servicedate))}}: {{$sermon->title}}</div>
          <div class="col-xs-12">{{$sermon->readings}}</div>
          @if (isset($sermon->individual))
        	  <div class="col-xs-12"><a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a></div>
          @else
            <div class="col-xs-12">Guest preacher</div>
          @endif
          <div class="col-xs-12">
            @foreach ($sermon->tags as $tag)
              <span class="label label-default"><a href="{{url('/')}}/subject/{{$tag->slug}}">{{$tag->name}}</a></span> 
            @endforeach
          </div>
    	</div>
    	<div class="col-md-8">
        <h3 class="text-center">{{$sermon->title}} <small>{{$sermon->readings}}</small></h3>
		    @include('connexion::shared.comments')
    	</div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ asset('public/vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    $('audio').mediaelementplayer({
      features: ['playpause','tracks','progress','volume'],
    });
  });
})(jQuery);
</script>
@include('connexion::shared.commentsjs', ['url' => route('admin.sermons.addcomment',array($sermon->series->id,$sermon->id))])
@endsection