{{ Form::bsText('groupname','Group name','Group name',$group->groupname) }}
{{ Form::bsText('description','Brief description','Brief description',$group->description) }}
{{ Form::bsSelect('grouptype','Group Type',array('fellowship','service','worship','course','admin'),$group->grouptype) }}