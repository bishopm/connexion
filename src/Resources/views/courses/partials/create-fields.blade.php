<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsSelect('category','Category',array('home group','course','self-study')) }}
{{ Form::bsTextarea('description','Description','Description') }}
<div class='form-group '>
  <label for="individual_id">Current group associated with Course</label>
  <select class="selectize" id="group_id" name="group_id">
  	<option selected value="0">No current group</option>
    @foreach ($groups as $group)
    	<option value="{{$group->id}}">{{$group->groupname}}</option>
    @endforeach
  </select>
</div> 
{{ Form::bsHidden('image') }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>