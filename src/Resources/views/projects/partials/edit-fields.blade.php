{{ Form::bsText('description','Description','Description',$project->description) }}
{{ Form::bsSelect('reminders','Reminders',array('none','weekly','monthly','quarterly'),$project->reminders) }}