{{ Form::bsText('groupname','Group name','Group name') }}
{{ Form::bsText('description','Brief description','Brief description') }}
{{ Form::bsSelect('grouptype','Group Type',array('fellowship','service','worship','course','admin')) }}<div class="form-group">
	<label for="publish" class="control-label">Publish to website</label>
	<input type="checkbox" name="publish">
</div>