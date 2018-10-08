<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text" value="{{$blog->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$blog->slug}}">
</div>
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
  @foreach ($tags as $tag)
    @if ((count($btags)) and (in_array($tag->name,$btags)))
        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
    @else
        <option value="{{$tag->name}}">{{$tag->name}}</option>
    @endif
  @endforeach
  </select>
</div>
<div class='form-group '>
  <label for="individual_id">Author</label>
  <select class="selectize" id="individual_id" name="individual_id">
    @foreach ($bloggers as $blogger)
    	@if ($blog->individual_id==$blogger->id)
	    	<option selected value="{{$blogger->id}}">{{$blogger->firstname}} {{$blogger->surname}}</option>
	    @else
			<option value="{{$blogger->id}}">{{$blogger->firstname}} {{$blogger->surname}}</option>
	    @endif
    @endforeach
  </select>
</div> 
@can('admin-backend')
  {{ Form::bsSelect('status','Status',array('Draft','Published'),$blog->status) }}
@else
  {{ Form::bsSelect('status','Status',array('Draft'),$blog->status) }}
@endcan

{{ Form::bsText('created_at','Publication date','Publication date', $blog->created_at) }}
@if (!$media)
  {{ Form::bsFile('image') }}
@else
  <div id="thumbdiv">
    {{ Form::bsImgpreview($media->getUrl(),120,'Image') }}
  </div>
  <div id="filediv" style="display:none;">
    {{ Form::bsFile('image') }}
  </div>
@endif
{{ Form::bsTextarea('body','Body','Body',$blog->body) }}