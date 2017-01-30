{{ Form::bsText('rostername','Roster name','eg: Sunday roster') }}
{{ Form::bsText('subcategories','Sub-categories','Comma separated values - eg: Service times in a Sunday roster') }}
{{ Form::bsText('message','Message','SMS message eg: Your duties this Sunday are:') }}
{{ Form::bsSelect('dayofweek','Day of week', [1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'])}}
{!! Form::label('groups','Group or groups', array('class'=>'control-label','title'=>'If you have sub-categories, choose multiple groups - eg: Different service teams for different Sunday services')) !!}
<select name="groups[]" data-placeholder="Choose groups..." class="selectize" multiple>
<option value=""></option>
@foreach ($groups as $thisgroup)
  @if ((isset($rostergroup)) and (in_array($thisgroup->id,$rostergroup)))
		<option selected value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
  @else
  	<option value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
  @endif
@endforeach
</select>
{!! Form::label('extrainfo','Groups needing extra information', array('class'=>'control-label','title'=>'If extra data must be added to the SMS - eg: Bible readings for readers')) !!}
<select name="extrainfo[]" data-placeholder="Choose groups..." class="selectize" multiple>
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
<select name="multichoice[]" data-placeholder="Choose groups..." class="selectize" multiple>
	<option value=""></option>
	@foreach ($groups as $thisgroup)
		@if ((isset($rostermulti)) and (in_array($thisgroup->id,$rostermulti)))
			<option selected value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
		@else
			<option value="{{$thisgroup->id}}">{{$thisgroup->groupname}}</option>
		@endif
	@endforeach
</select>