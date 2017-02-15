{{ Form::bsText('description','Description','Description') }}
<div class='form-group '>
	<label for="society_id">Venue</label>
	<select class="selectize" placeholder="Choose a venue" id="society_id" name="society_id">
		<option></option>
		@foreach ($societies as $society)
  			<option value="{{$society->id}}">{{$society->society}}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="society_id">Date and time</label>
    <div class='input-group date' id='meetingdatetime'>
        <input type='text' class="form-control" />
        <span class="input-group-addon">
	        <span class="fa fa-calendar"></span>
        </span>
    </div>
</div>