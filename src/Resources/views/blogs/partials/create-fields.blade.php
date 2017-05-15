<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
	@foreach ($tags as $tag)
	  <option value="{{$tag->name}}">{{$tag->name}}</option>
	@endforeach
  </select>
</div>
<div class='form-group '>
  <label for="individual_id">Author</label>
  <select class="selectize" id="individual_id" name="individual_id">
    @foreach ($bloggers as $blogger)
      <option value="{{$blogger->id}}">{{$blogger->firstname}} {{$blogger->surname}}</option>
    @endforeach
  </select>
</div>
@can('admin-backend')
  {{ Form::bsSelect('status','Status',array('Draft','Published')) }}
@else
  {{ Form::bsSelect('status','Status',array('Draft')) }}
@endcan
{{ Form::bsText('created_at','Publication date','Publication date') }}
{{ Form::bsTextarea('body','Body','Body') }}
@if (isset($media))
  {{ Form::bsFile('image') }}
@endif

