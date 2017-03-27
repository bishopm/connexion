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
@if (!count($media))
{{ Form::bsFile('image') }}
@else
<div id="thumbdiv">
	{{ Form::bsImgpreview($media->getUrl(),300,'Image') }}
</div>
<div id="filediv" style="display:none;">
	{{ Form::bsFile('image') }}
</div>
@endif