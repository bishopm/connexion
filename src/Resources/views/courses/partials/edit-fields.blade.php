<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text" value="{{$course->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$course->slug}}">
</div>
{{ Form::bsSelect('category','Category',array('home group','course','self-study'),$course->category) }}
{{ Form::bsTextarea('description','Description','Description',$course->description) }}
<div class='form-group '>
  <label for="individual_id">Current group associated with Course</label>
  <select class="selectize" id="group_id" name="group_id">
    <option value="0">No current group</option>
    @foreach ($groups as $group)
    	@if ($course->group_id==$group->id)
	    	<option selected value="{{$group->id}}">{{$group->groupname}}</option>
	    @else
			<option value="{{$group->id}}">{{$group->groupname}}</option>
	    @endif
    @endforeach
  </select>
</div> 
{{ Form::bsHidden('image',$course->image) }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>