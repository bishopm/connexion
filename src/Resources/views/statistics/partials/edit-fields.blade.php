{{ Form::bsText('statdate','Service date','Service date',$statistic->statdate) }}
<div class="form-group">
    <label for="service_id" class="control-label">Service</label>
    <select name="service_id" class="selectize">
      @foreach ($services as $service)
      	@if ($service->id==$statistic->service_id)
	        <option selected value="{{$service->id}}">{{$service->servicetime}}</option>
	    @else
			<option value="{{$service->id}}">{{$service->servicetime}}</option>
	    @endif
      @endforeach
    </select>
</div>
{{ Form::bsText('attendance','Attendance','Attendance',$statistic->attendance) }}