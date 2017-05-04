{{ Form::bsText('name','Role name','Role name',$role->name) }}
{{ Form::bsText('slug','Slug','Slug',$role->slug) }}
<div class="form-group">
    <label for="permissions" class="control-label">Permissions</label>
    <select multiple name="permissions[]" class="selectize">
    	@foreach ($permissions as $perm)
    		@if (array_key_exists($perm, $role->permissions))
	      		<option selected value="{{$perm}}">{{$perm}}</option>
	      	@else
				<option value="{{$perm}}">{{$perm}}</option>
	      	@endif
      	@endforeach
    </select>
</div>