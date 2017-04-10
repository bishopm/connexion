{{ Form::bsText('name','Username','Username') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsPassword('password','Password','Password') }}
{{ Form::bsText('bio','Brief bio','Brief bio') }}
{{ Form::bsText('google_calendar','Google Calendar','Google Calendar') }}
{!! Form::label('calendar_colour','Calendar colour', array('class'=>'control-label','placeholder'=>'Calendar colour')) !!}
<div class="input-group colorpicker">
	<div class="input-group-addon"><i></i></div>
    {!! Form::text('calendar_colour', null, array('class' => 'form-control')) !!}
</div>
{{ Form::bsText('slack_username','Slack username','Slack username') }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack')) }}
{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No')) }}