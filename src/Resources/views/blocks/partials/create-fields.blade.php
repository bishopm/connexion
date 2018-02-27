{{ Form::bsText('description','Description','Description') }}
{{ Form::bsSelect('column','Column',array('1','2','3')) }}
{{ Form::bsSelect('width','Width (12  = 100%)',array('1','2','3','4','5','6','7','8','9','10','11','12')) }}
{{ Form::bsText('order','Order','Order') }}
{{ Form::bsText('active','Active','Active') }}
{{ Form::bsSelect('filename','Filename',$files) }}

