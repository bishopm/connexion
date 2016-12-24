{{ Form::bsText('title','Title','Title') }}
{{ Form::bsText('slug','Slug','Slug') }}
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
{{ Form::bsSelect('status','Status',array('Draft','Published')) }}
{{ Form::bsTextarea('body','Body','Body') }}

