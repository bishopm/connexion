<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsSelect('template','Template',$templates)}}
<div class='form-group '>
  <label for="tags">Blog tags (for pages using sidebar template)</label>
  <select name="tags[]" class="selectize" multiple>
	@foreach ($tags as $tag)
	  <option value="{{$tag->name}}">{{$tag->name}}</option>
	@endforeach
  </select>
</div>
{{ Form::bsTextarea('body','Body','Body') }}