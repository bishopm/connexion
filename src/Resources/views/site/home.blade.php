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
      <ul class="top30 list-unstyled">
          <li>Blog post 1</li>
          <li>Blog post 2</li>
          <li>Blog post 3</li>
          <li>Blog post 4</li>
          <li>Blog post 5</li>
      </ul>
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      <img class="top17" src="{{$sermon->series->getMedia('image')->first()->getUrl()}}">
      <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
      <div class="col-md-12">{{date("j M", strtotime($sermon->servicedate))}}: {{$sermon->sermon}}</div>
      <div class="col-md-12">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</div>
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/contact.png')}}">
      <h4>Contact us</h4>
      <div id="map_canvas" class="top30" style="height:200px;"></div>
      <ul class="list-unstyled top10">
          <li><a target="_blank" href="https://www.google.co.za/maps/place/Umhlali+Methodist+Church/@-29.48198,31.2204723,17z">5 Burnedale Place, Umhlali</a></li>      
          <li><i class="fa fa-phone"></i> 032 947 0173 | <i class="fa fa-envelope"></i> {{ HTML::mailto('info@umc.org.za') }}</li> 
          <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
          <li><b>Children and youth:</b> Sundays 08h30</li>
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
  });
})(jQuery);
$( document ).ready(function() {
    google.maps.event.addDomListener(window, 'load', initialize(11,{{$setting['home_latitude']}},{{$setting['home_longitude']}}));
});
</script>
@endsection