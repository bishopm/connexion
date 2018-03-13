{{ Form::bsText('society','Society name','Society name',$society->society) }}
{{ Form::bsText('address','Address','Address',$society->address) }}
{{ Form::bsText('contact','Phone / email','Phone / email',$society->contact) }}
{{ Form::bsText('website','Website','Website',$society->website) }}
<div id="map_canvas" style="height:350px;"></div>
{{ Form::bsText('latitude','Latitude','Latitude',$society->latitude) }}
{{ Form::bsText('longitude','Longitude','Longitude',$society->longitude) }}