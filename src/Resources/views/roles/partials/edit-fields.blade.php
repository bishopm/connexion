{{ Form::bsText('name','Role name','Role name',$role->name) }}
<div class="form-group">
    <label for="permissions" class="control-label">Permissions</label>
	<select class="selectize" placeholder="Add or remove role permissions" id="permissions" name="permissions[]" multiple>
		@foreach ($permissions as $permission)
			@if ($role->permissions->contains('name',$permission->name))
				<option selected value="{{$permission->id}}">{{$permission->name}}</option>
			@else
				<option value="{{$permission->id}}">{{$permission->name}}</option>
			@endif
		@endforeach
	</select>
</div>