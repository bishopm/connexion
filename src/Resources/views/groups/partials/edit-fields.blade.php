{{ Form::bsText('groupname','Group name','Group name',$group->groupname) }}
{{ Form::bsText('description','Brief description','Brief description',$group->description) }}
{{ Form::bsSelect('grouptype','Group Type',array('fellowship','service','worship','course','admin'),$group->grouptype) }}
<div class="form-group">
	<label for="publish" class="control-label">Publish to website</label>
	@if ($group->publish)
		<input type="checkbox" name="publish" value="1" checked>
	@else
		<input type="checkbox" name="publish" value="1">
	@endif
</div>