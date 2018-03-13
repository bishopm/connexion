{{ Form::bsText('society','Society name','Society name') }}
{{ Form::bsText('address','Address','Address') }}
{{ Form::bsText('contact','Phone / email','Phone / email') }}
{{ Form::bsText('website','Website','Website') }}
<div id="map_canvas" style="height:350px;"></div>
{{ Form::bsText('latitude','Latitude','Latitude',$setting['home_latitude']) }}
{{ Form::bsText('longitude','Longitude','Longitude',$setting['home_longitude']) }}
