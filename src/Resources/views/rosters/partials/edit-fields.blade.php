{{ Form::bsText('rostername','Roster name','eg: Sunday roster',$roster->rostername) }}
{{ Form::bsText('subcategories','Sub-categories','Comma separated values - eg: Service times in a Sunday roster',$roster->subcategories) }}
{{ Form::bsText('message','Message','SMS message eg: Your duties this Sunday are:',$roster->message) }}
<div class="form-group">
    <label for="Day of week" class="control-label">Day Of Week</label>
	<select class="form-control" id="dayofweek" name="dayofweek">
		@if ($roster->dayofweek==1)
			<option selected value="1">Monday</option>
		@else
			<option value="1">Monday</option>
		@endif
		@if ($roster->dayofweek==2)
			<option selected value="2">Tuesday</option>
		@else
			<option value="2">Tuesday</option>
		@endif
		@if ($roster->dayofweek==3)
			<option selected value="3">Wednesday</option>
		@else
			<option value="3">Wednesday</option>
		@endif
		@if ($roster->dayofweek==4)
			<option selected value="4">Thursday</option>
		@else
			<option value="4">Thursday</option>
		@endif
		@if ($roster->dayofweek==5)
			<option selected value="5">Friday</option>
		@else
			<option value="5">Friday</option>
		@endif
		@if ($roster->dayofweek==6)
			<option selected value="6">Saturday</option>
		@else
			<option value="6">Saturday</option>
		@endif
		@if ($roster->dayofweek==7)
			<option selected value="7">Sunday</option>
		@else
			<option value="7">Sunday</option>
		@endif
	</select>
</div>
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
{!! Form::label('role_label','Access for specific role', array('class'=>'control-label','title'=>'Specify any other role who may access this roster')) !!}
<select name="role_id" data-placeholder="Choose a role or leave blank..." class="selectize">
<option value=""></option>
@foreach ($roles as $key=>$role)
  @if ((isset($roster->role_id)) and ($roster->role_id == $key))
	<option selected value="{{$key}}">{{$role}}</option>
  @else
  	<option value="{{$key}}">{{$role}}</option>
  @endif
@endforeach
</select>