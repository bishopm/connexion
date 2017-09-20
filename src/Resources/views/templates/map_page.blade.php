@extends('connexion::templates.frontend')

@if (isset($titletagtitle))
	@section('title',$titletagtitle)
@endif

@section('content')
<div class="container">
	<div class="row">
	  <div class="col-md-8 top30">
	    {!!$page->body!!}
	  </div>
	  <div class="col-md-4 top30">
	  	<div id="map_canvas" class="top10" style="height:350px;"></div>
	  </div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
<script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    google.maps.event.addDomListener(window, 'load', showMap(14,{{$setting['home_latitude']}},{{$setting['home_longitude']}}));
  });
})(jQuery);
</script>
@endsection