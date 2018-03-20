{{ Form::bsText('name','Username','Username') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsPassword('password','Password','Password') }}
{{ Form::bsText('bio','Brief bio','Brief bio') }}
{{ Form::bsText('slack_username','Slack username','Slack username') }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack')) }}
{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No')) }}