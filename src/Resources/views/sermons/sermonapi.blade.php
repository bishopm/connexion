@extends('connexion::templates.api')

@section('css')
<link href="{{ asset('/public/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<a title="View sermon series: {{$sermon->series->title}}" href="{{url('/')}}/sermons/{{$sermon->series->slug}}"><img class="top17" src="{{url('/')}}/public/storage/series/{{$sermon->series->image}}"></a>
    	    <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
          <div class="col-xs-12">{{date("j M", strtotime($sermon->servicedate))}}: {{$sermon->title}}</div>
          <div class="col-xs-12">{{$sermon->readings}}</div>
          @if (isset($sermon->individual))
        	  <div class="col-xs-12">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</div>
          @else
            <div class="col-xs-12">Guest preacher</div>
          @endif
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
@endsection