{{ Form::bsText('groupname','Group name','Group name') }}
{{ Form::bsText('slug','Slug','Slug') }}
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
{{ Form::bsSelect('grouptype','Group Type',array('fellowship','service','worship','course','admin','event')) }}<div class="form-group">
	<label for="publish" class="control-label">Publish to website</label>
	<input type="checkbox" name="publish" value="1">
</div>