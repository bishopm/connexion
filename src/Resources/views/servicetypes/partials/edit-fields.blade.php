{{ Form::bsText('tag','Service type','Service type',$servicetype->tag) }}
{{ Form::bsText('description','Description','Description',$servicetype->description) }}
{{ Form::bsHidden('circuit_id',$circuit) }}