{{ Form::bsText('name','Username','Username') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsPassword('password','Password','Password') }}
{{ Form::bsText('google_calendar','Google Calendar','Google Calendar',$user->google_calendar) }}
{!! Form::label('calendar_colour','Calendar colour', array('class'=>'control-label','placeholder'=>'Calendar colour')) !!}
<div class="input-group colorpicker">
	<div class="input-group-addon"><i></i></div>
    {!! Form::text('calendar_colour', null, array('class' => 'form-control')) !!}
</div>