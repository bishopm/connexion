{{ Form::bsText('firstname','First name','First name',$preacher->firstname) }}
{{ Form::bsText('surname','Surname','Surname',$preacher->surname) }}
{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev'),$preacher->title) }}
{{ Form::bsText('fullplan','Year first on full plan (or Trial)','Year first on full plan (or Trial)',$preacher->fullplan) }}
{{ Form::bsText('phone','Cellphone','Cellphone',$preacher->phone) }}
<div class="form-group">
    <label for="society_id" class="control-label">Society</label>
    <select name="society_id" class="selectize">
      <option></option>
      @foreach ($societies as $society)
        @if ($preacher->society_id==$society->id)
          <option selected value="{{$society->id}}">{{$society->society}}</option>
        @else
          <option value="{{$society->id}}">{{$society->society}}</option>
        @endif
      @endforeach
    </select>
</div>
<div class="form-group">
    <label for="positions" class="control-label">Role/s</label>
    <select name="positions[]" multiple class="selectize">
      <option></option>
      @foreach ($positions as $position)
        @if (in_array($position->id,$pos))
          <option selected value="{{$position->id}}">{{$position->position}}</option>
        @else
          <option value="{{$position->id}}">{{$position->position}}</option>
        @endif
      @endforeach
    </select>
</div>
{{ Form::bsFile('image') }}
{{ Form::bsHidden('circuit_id',$circuit) }}
<div class="form-group" id="deletetype" style="display:none;">
  <label for="Deletion_type" class="control-label">Why is this preacher being deleted?</label>
  <select name="deletion_type" id="deletion_type" class="selectize">
    <option value=""></option>
    <option value="deceased">Deceased</option>
    <option value="transferred">Transferred</option>
    <option value="resigned">Resigned</option>
    <option value="discontinued">Discontinued</option>
  </select>
</div>
<div class="form-group" id="deletenotes" style="display:none;">
  <label for="Deletion_notes" class="control-label">Notes regarding removal of preacher's name</label>
  <input class="form-control" id="deletion_notes" placeholder="Notes" name="deletion_notes" type="text">
</div>