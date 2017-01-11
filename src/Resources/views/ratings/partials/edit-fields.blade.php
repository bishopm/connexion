<div class="box-body">
  <div class="form-group">
    <label for="group_id">Group</label>
    <select class="input-group" name="group_id">
        <option></option>
        @foreach ($groups as $group)
        	@if ($rating['group_id']==$group->id)
			<option selected value="{{$group->id}}">{{$group->groupname}}</option>
        	@else
          	<option value="{{$group->id}}">{{$group->groupname}}</option>
          @endif
        @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="rating">Rating</label>
 	  <script src="{{url('/')}}/modules/website/bootstrap-rating-input/bootstrap-rating-input.min.js" type="text/javascript"></script>
 	  <input type="number" name="rating" id="rating" data-clearable="reset" value="{{$rating->rating}}" class="rating" />
  </div>
  {!! Form::bsTextarea('comment', 'Comment', 'Comment', $rating->comment) !!}
</div>
