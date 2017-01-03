@extends('base::templates.webpage')

@section('css')
<link href="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@include('base::shared.carousel')
<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/blog.png')}}">
      <h4>From our Blog</h4>
      <ul class="top30 list-unstyled text-left">
        @forelse ($blogs as $blog)
          <li>{{date("j M", strtotime($blog->created_at))}}&nbsp;<a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></li>
        @empty
          <li>No blog posts have been published yet</li>
        @endforelse
      </ul>
      <img class="top17" src="{{asset('vendor/bishopm/images/diary.png')}}">
      <h4>The week ahead</h4>
      <ul class="top30 list-unstyled text-left">
      </ul>
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      @if ($sermon)
        <img class="top17" src="{{$sermon->series->getMedia('image')->first()->getUrl()}}">
        <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
        <div class="col-md-12">{{date("j M", strtotime($sermon->servicedate))}}: {{$sermon->sermon}}</div>
        <div class="col-md-12"><a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a></div>
      @else
        No sermons have been added yet
      @endif
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/contact.png')}}">
      <h4>Find us</h4>
      <ul class="list-unstyled top17">
          <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
          <li><b>Children and youth:</b> Sundays 08h30</li>
      </ul>      
      <div id="map_canvas" class="top10" style="height:250px;"></div>
      <ul class="list-unstyled top10">
        <li><a href="{{url('/')}}/contact">Directions and full contact details</a></li>
      </ul>
    </div>
  </div><!-- /.row -->
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
<script src="{{url('/')}}/vendor/bishopm/js/mapsinglepoint.js" type="text/javascript"></script>
<script src="{{ asset('vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    $('.carousel').carousel({
      pause: "false",
      interval: 4000
    });
    $('audio').mediaelementplayer({
      features: ['playpause','tracks','progress','volume'],
    });
    google.maps.event.addDomListener(window, 'load', initialize(11,{{$setting['home_latitude']}},{{$setting['home_longitude']}}));
  });
})(jQuery);
</script>
@endsection