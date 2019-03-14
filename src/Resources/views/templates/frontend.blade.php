@extends('connexion::templates.webmaster')

@if (isset($titletagtitle))
	@section('title',$titletagtitle)
@endif

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
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