{{ Form::bsText('name','Role name','Role name') }}
{{ Form::bsText('slug','Slug','Slug') }}
<div class="form-group">
    <label for="permissions" class="control-label">Permissions</label>
    <select multiple name="permissions[]" class="selectize">
    	@foreach ($permissions as $perm)
    		<option value="{{$perm}}">{{$perm}}</option>
      	@endforeach
    </select>
</div>