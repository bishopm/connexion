var map;
var lastMarker;

function initialize(zz) {
		var map_canvas = document.getElementById('map_canvas');
		lat=document.getElementById("latitude").value;
		lng=document.getElementById("longitude").value;
		pos = new google.maps.LatLng(lat, lng);
		var map_options = {
				center: pos,
				zoom: zz,
				mapTypeId: google.maps.MapTypeId.HYBRID
		}
		map = new google.maps.Map(map_canvas, map_options)
		google.maps.event.addListener(map, 'click', function(event) {
				placeMarker(event.latLng);
		});
		placeMarker(pos);
}

function showMap(zzz,lat,lng){
		var map_canvas = document.getElementById('map_canvas');
		pos = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
		var map_options = {
				center: pos,
				zoom: zzz,
				mapTypeId: google.maps.MapTypeId.HYBRID
		}
		map = new google.maps.Map(map_canvas, map_options)
		var marker = new google.maps.Marker({
				position: pos,
				draggable: false,
				map: map
		});
}

function placeMarker(location) {
		if (lastMarker != null)
				lastMarker.setMap(null);
		var marker = new google.maps.Marker({
				position: location,
				draggable: true,
				map: map
		});
		lastMarker = marker;
		google.maps.event.addListener(marker, 'dragend', function(event) {
				placeMarker(event.latLng);
		});
		items = location.toString().split(", ");
		document.getElementById("latitude").value = items[0].substring(1);
		document.getElementById("longitude").value = items[1].substring(0,items[1].length-1);
}
