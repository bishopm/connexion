{{ Form::bsText('society','Society name','Society name',$society->society) }}
{{ Form::bsText('address','Address','Address',$society->address) }}
{{ Form::bsText('contact','Phone / email','Phone / email',$society->contact) }}
{{ Form::bsText('website','Website','Website',$society->website) }}
<div id="map_canvas" style="height:350px;"></div>
{{ Form::bsText('latitude','Latitude','Latitude',$society->latitude) }}
{{ Form::bsText('longitude','Longitude','Longitude',$society->longitude) }}
<div class="form-group" id="deletetype" style="display:none;">
  <label for="Deletion_type" class="control-label">Why is this society being deleted?</label>
  <select name="deletion_type" id="deletion_type" class="selectize">
    <option value=""></option>
    <option value="deceased">Closed</option>
    <option value="transferred">Added in error</option>
  </select>
</div>
<div class="form-group" id="deletenotes" style="display:none;">
  <label for="Deletion_notes" class="control-label">Notes regarding removal of society</label>
  <input class="form-control" id="deletion_notes" placeholder="Notes" name="deletion_notes" type="text">
</div>