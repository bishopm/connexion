<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" placeholder="Title" name="title" id="title" type="text" value="{{$page->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" placeholder="Slug" name="slug" id="slug" type="text"  value="{{$page->slug}}">
</div>
{{ Form::bsSelect('template','Template',$templates,$page->template)}}
<div class='form-group '>
  <label for="tags">Blog tags (for pages using sidebar template)</label>
  <select name="tags[]" class="selectize" multiple>
  @foreach ($tags as $tag)
    @if ((count($btags)) and (in_array($tag->name,$btags)))
        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
    @else
        <option value="{{$tag->name}}">{{$tag->name}}</option>
    @endif
  @endforeach
  </select>
</div>
{{ Form::bsTextarea('body','Body','Body', $page->body) }}