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
			<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
    
	  	<div id="map" class="top10" style="height:350px;"></div>
	  </div>
	</div>
</div>
@endsection

@section('js')
	<script>
		var mymap = L.map('map').setView([{{$setting['home_latitude']}}, {{$setting['home_longitude']}}], 14);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?access_token={accessToken}', {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				maxZoom: 18,
				id: 'mapbox.streets',
				accessToken: 'pk.eyJ1IjoiYmlzaG9wbSIsImEiOiJjanNjenJ3MHMwcWRyM3lsbmdoaDU3ejI5In0.M1x6KVBqYxC2ro36_Ipz_w'
		}).addTo(mymap);
		var marker = L.marker([{{$setting['home_latitude']}}, {{$setting['home_longitude']}}]).addTo(mymap);
</script>
@endsection