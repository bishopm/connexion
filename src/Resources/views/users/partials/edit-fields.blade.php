{{ Form::bsText('name','Username','Username',$user->name) }}
{{ Form::bsText('email','Email','Email',$user->email) }}
{{ Form::bsText('bio','Brief bio','Brief bio',$user->bio) }}
{{ Form::bsText('slack_username','Slack username','Slack username',$user->slack_username) }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack'),$user->notification_channel) }}
{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No'),$user->allow_messages) }}