{{ Form::bsText('title','Title','Title',$blog->title) }}
{{ Form::bsText('slug','Slug','Slug',$blog->slug) }}
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
{{ Form::bsTextarea('body','Body','Body',,$blog->body) }}