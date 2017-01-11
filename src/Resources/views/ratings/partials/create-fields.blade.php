<div class="form-group">
    <label for="group_id">Group</label>
    <select class="input-group" name="group_id">
        <option></option>
        @foreach ($groups as $group)
            <option value="{{$group->id}}">{{$group->groupname}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
  <label for="rating">Rating</label>
  <input type="number" name="rating" id="rating" data-clearable="reset" class="rating" />
</div>
{!! Form::bsTextarea('comment', 'Comment', 'Comment') !!}