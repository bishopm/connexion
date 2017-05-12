@extends('connexion::templates.webmaster')

@section('css')

@stop

@section('content')
	@yield('content')
@stop

@section('js')
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
@stop