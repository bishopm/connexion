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
{{ Form::bsText('group_id','Linked to group event','Linked to group event', $course->group_id) }}
{{ Form::bsHidden('image',$course->image) }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>