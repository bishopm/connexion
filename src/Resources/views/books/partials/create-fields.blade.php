<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsText('author','Author','Author') }}
{{ Form::bsTextarea('description','Description','Description') }}
{{ Form::bsFile('image') }}
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
	@foreach ($tags as $tag)
	  <option value="{{$tag->name}}">{{$tag->name}}</option>
	@endforeach
  </select>
</div>
{{ Form::bsText('stock','Current stock','Current stock') }}
{{ Form::bsText('saleprice','Sale price','Sale price') }}
{{ Form::bsText('costprice','Cost price','Cost price') }}