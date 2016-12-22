var map;
var lastMarker;

function initialize(zz,lat,lng) {
		var map_canvas = document.getElementById('map_canvas');
		pos = new google.maps.LatLng(lat, lng);
		var map_options = {
				center: pos,
				zoom: zz,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(map_canvas, map_options)
		google.maps.event.addListener(map, 'click', function(event) {
				placeMarker(event.latLng);
		});
		placeMarker(pos);
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
}
