{{ Form::bsText('name','Role name','Role name') }}
<div class="form-group">
    <label for="permissions" class="control-label">Permissions</label>
	<select class="selectize" placeholder="Add or remove role permissions" id="permissions" name="permissions[]" multiple>
		@foreach ($permissions as $permission)
			<option value="{{$permission->id}}">{{$permission->name}}</option>
		@endforeach
	</select>
</div>