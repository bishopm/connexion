<div class="form-group">
  <label for="name">Series title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text" value="{{$series->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$series->slug}}">
</div>
{{ Form::bsText('description','Description','Description',$series->description) }}
{{ Form::bsText('created_at','Starting date','Starting date',$series->created_at) }}
{{ Form::bsHidden('image',$media) }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>