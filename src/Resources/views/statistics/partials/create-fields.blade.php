{{ Form::bsText('statdate','Service date','Service date',date('Y-m-d',strtotime('last Sunday'))) }}
<div class="form-group">
    <label for="service_id" class="control-label">Service</label>
    <select name="service_id" class="selectize">
      @foreach ($services as $service)
         <option value="{{$service->id}}">{{$service->servicetime}}</option>
      @endforeach
    </select>
</div>
{{ Form::bsText('attendance','Attendance','Attendance') }}