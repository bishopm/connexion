{{ Form::bsText('groupname','Event name','Event name') }}
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsTextarea('description','Brief description','Brief description') }}
<div class='form-group '>
  <label for="individual_id">Leader</label>
  <select class="selectize" id="leader" name="leader">
  	<option></option>
    @foreach ($indivs as $indiv)
      <option value="{{$indiv->id}}">{{$indiv->surname}}, {{$indiv->firstname}}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
	<label for="society_id">Date and time</label>
    <div class='input-group date' id='eventdatetime'>
        <input type='text' class="form-control" name="eventdatetime"/>
        <span class="input-group-addon">
	        <span class="fa fa-calendar"></span>
        </span>
    </div>
</div>
{{ Form::hidden('grouptype','event') }}
<div class="form-group">
	<label for="publish" class="control-label">Publish to website</label>
	<input type="checkbox" name="publish" value="1">
</div>
<div class="form-group">
	<label for="payment" class="control-label">Include QR code for payment?</label>
	<input type="checkbox" name="payment" value="1">
</div>