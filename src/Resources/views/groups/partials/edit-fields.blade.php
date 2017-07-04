{{ Form::bsText('groupname','Group name','Group name',$group->groupname) }}
{{ Form::bsTextarea('description','Brief description','Brief description',$group->description) }}
@if (!isset($webedit))
  @can('admin-backend')
    {{ Form::bsText('slug','Slug','Slug',$group->slug) }}
  @endcan
  <div class='form-group '>
    <label for="individual_id">Leader</label>
    <select class="selectize" id="leader" name="leader">
      @foreach ($indivs as $indiv)
      	@if ($indiv->id==$group->leader)
      		<option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
      	@else
      		<option value="{{$indiv->id}}">{{$indiv->surname}}, {{$indiv->firstname}}</option>
      	@endif
      @endforeach
    </select>
  </div>
  {{ Form::bsSelect('grouptype','Group Type',array('fellowship','service','worship','course','admin','event'),$group->grouptype) }}
  <div class="form-group">
  	<label for="publish" class="control-label">Publish to website</label>
  	@if ($group->publish)
  		<input type="checkbox" name="publish" value="1" checked>
  	@else
  		<input type="checkbox" name="publish" value="1">
  	@endif
  </div>
@else
  <input type="hidden" name="publish" value="webedit">
@endif