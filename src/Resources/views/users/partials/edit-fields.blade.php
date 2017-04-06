{{ Form::bsText('name','Username','Username',$user->name) }}
{{ Form::bsText('email','Email','Email',$user->email) }}
{{ Form::bsPassword('password','Password','Password') }}
{{ Form::bsText('bio','Brief bio','Brief bio',$user->bio) }}
{{ Form::bsText('google_calendar','Google Calendar','Google Calendar',$user->google_calendar) }}
<div class="form-group">
	{!! Form::label('calendar_colour','Calendar colour', array('class'=>'control-label','placeholder'=>'Calendar colour')) !!}
	<div class="input-group colorpicker">
	    <div class="input-group-addon"><i></i></div>
	    {!! Form::text('calendar_colour', $user->calendar_colour, array('class' => 'form-control')) !!}    
	</div>
</div>
{{ Form::bsText('telegram_username','Telegram username','Telegram username',$user->telegram_username) }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Telegram',$user->notification_channel)) }}