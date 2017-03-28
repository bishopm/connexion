<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" placeholder="Title" name="title" id="title" type="text" value="{{$page->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" placeholder="Slug" name="slug" id="slug" type="text"  value="{{$page->slug}}">
</div>
{{ Form::bsSelect('template','Template',$templates,$page->template)}}
{{ Form::bsTextarea('body','Body','Body', $page->body) }}