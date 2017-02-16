{{ Form::bsText('description','Description','Description',$weekday->description) }}
<div class="form-group">
	<label for="society_id">Date</label>
    <div class='input-group date' id='servicedate'>
        <input type="text" class="form-control" name="servicedate" value="{{date("Y-m-d",$weekday->servicedate)}}"/>
        <span class="input-group-addon">
	        <span class="fa fa-calendar"></span>
        </span>
    </div>
</div>