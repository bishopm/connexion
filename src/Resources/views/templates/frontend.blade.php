@extends('connexion::templates.webmaster')

@if (isset($titletagtitle))
	@section('title',$titletagtitle)
@endif

@section('css')

@stop

@section('content')
	@yield('content')
@stop

@section('js')
@if(isset($slideshow))
<script type="text/javascript">
  (function ($) {
    jQuery(window).on('load', function() {
      $('.carousel').carousel({
        pause: "false",
        interval: {{$slideshow->duration}}000
      });
    });
  })(jQuery);
</script>
@endif
@stop