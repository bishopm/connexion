@extends('connexion::templates.frontend')

@section('title','Home page')

@section('css')
<link href="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container">
  <div class="row">
    @foreach ($blocks as $block)
      <div class="col-md-{{$block->width}} text-center" style="z-index: 1;">
        @include('vendor/bishopm/blocks/' . $block->filename)
      </div>
    @endforeach
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/vendor/bishopm/js/clamp.js') }}" type="text/javascript"></script>
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
      var highlighted = document.getElementById("highlighted");
      $clamp(highlighted, {clamp: 7});
    });
  })(jQuery);
</script>
@endsection