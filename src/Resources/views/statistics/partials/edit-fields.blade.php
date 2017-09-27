{{ Form::bsText('statdate','Service date','Service date',$statistic->statdate) }}
<div class="form-group">
    <label for="service_id" class="control-label">Service</label>
    <select name="servicetime" class="selectize">
      @foreach ($services as $service)
      	@if ($service==$statistic->servicetime)
	        <option selected value="{{$service}}">{{$service}}</option>
	    @else
			    <option value="{{$service}}">{{$service}}</option>
	    @endif
      @endforeach
    </select>
</div>
{{ Form::bsText('attendance','Attendance','Attendance',$statistic->attendance) }}
<div class="form-group">
  <label class="control-label">Exclude major festivals</label>
  <div>
    @if ($statistic->included)
      <input type="radio" class="majorservice" name="included" value="1" checked> Included (normal service)
      &nbsp;<input type="radio" class="majorservice" name="included" value="0"> Exclude abnormal service from statistics
    @else 
      <input type="radio" class="majorservice" name="included" value="0"> Included (normal service)
      &nbsp;<input type="radio" class="majorservice" name="included" value="1" checked> Exclude abnormal service from statistics
    @endif
  </div>
</div>