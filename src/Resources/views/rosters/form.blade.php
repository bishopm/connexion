<div class="box-body">
	{!! Form::label('rostername','Roster name', array('class'=>'control-label','title'=>'eg: Sunday roster')) !!}
	{!! Form::text('rostername', null, array('class' => 'form-control')) !!}
	{!! Form::label('subcategories','Sub-categories', array('class'=>'control-label','title'=>'Comma separated values. eg: Service times in a Sunday roster. These subcategories must be contained in the group names that will be used - eg: use a sub-category of 08h30 for a group named 08h30 Readers')) !!}
	{!! Form::text('subcategories', null, array('class' => 'form-control')) !!}
	{!! Form::label('message','Message', array('class'=>'control-label','title'=>'SMS message eg: Your duties this Sunday are:')) !!}
	{!! Form::text('message', null, array('class' => 'form-control')) !!}
	{!! Form::label('dayofweek','Day of week', array('class'=>'control-label','title'=>'eg: Sunday')) !!}
	{!! Form::select('dayofweek', [1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'], null, array('class' => 'form-control')) !!}
	{!! Form::label('groups','Groups', array('class'=>'control-label','title'=>'If you have sub-categories, choose multiple groups - eg: Different service teams for different Sunday services')) !!}
	<select name="groups[]" data-placeholder="Choose groups..." class="form-control select2" multiple style="width:100%;">
    <option value=""></option>
    @foreach ($groups as $thisgroup)
    	@if ((isset($rostergroup)) and (in_array($thisgroup->id,$rostergroup)))
    		<option selected value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
      @else
      	<option value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
      @endif
    @endforeach
  </select>
	{!! Form::label('groups','Extra information', array('class'=>'control-label','title'=>'If extra data must be added to the SMS - eg: Bible readings for readers')) !!}
	<select name="extrainfo[]" data-placeholder="Choose groups..." class="form-control select2" multiple style="width:100%;">
		<option value=""></option>
		@foreach ($groups as $thisgroup)
			@if ((isset($rosterextra)) and (in_array($thisgroup->id,$rosterextra)))
				<option selected value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
			@else
				<option value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
			@endif
		@endforeach
  </select>
  {!! Form::label('groups','Multiple selections', array('class'=>'control-label','title'=>'Where more than one person will be on duty for the same task - eg: Tea servers')) !!}
	<select name="multichoice[]" data-placeholder="Choose groups..." class="form-control select2" multiple style="width:100%;">
	  <option value=""></option>
    @foreach ($groups as $thisgroup)
    	@if ((isset($rostermulti)) and (in_array($thisgroup->id,$rostermulti)))
    		<option selected value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
    	@else
    		<option value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
    	@endif
    @endforeach
  </select>
	<script type="text/javascript">$(".select2").select2();</script>
</div>
