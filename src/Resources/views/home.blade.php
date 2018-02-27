@extends('connexion::templates.frontend')

@section('title','Home page')

@section('css')
<link href="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    @foreach ($blocks as $block)
      <div class="col-md-{{$block->width}} text-center" style="z-index: 1;">
        {!!$block->code!!}
      </div>
    @endforeach
  </div><!-- /.row -->
</div>
@endsection

@section('js')
<script src="{{ asset('/vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
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
</script>
@endsection