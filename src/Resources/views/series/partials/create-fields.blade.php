<div class="form-group">
  <label for="name">Series title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsText('description','Description','Description') }}
{{ Form::bsText('created_at','Starting date','Starting date') }}
{{ Form::bsFile('image') }}