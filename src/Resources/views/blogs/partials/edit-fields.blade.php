{{ Form::bsText('title','Title','Title',$blog->title) }}
{{ Form::bsText('slug','Slug','Slug',$blog->slug) }}
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
{{ Form::bsSelect('status','Status',array('Draft','Published'),$blog->status) }}
{{ Form::bsTextarea('body','Body','Body',$blog->body) }}