{{ Form::bsText('description','Description','Description',$block->description) }}
{{ Form::bsSelect('column','Column',array('1','2','3'),$block->column) }}
{{ Form::bsSelect('width','Width (12  = 100%)',array('1','2','3','4','5','6','7','8','9','10','11','12'),$block->width) }}
{{ Form::bsText('order','Order','Order',$block->order) }}
{{ Form::bsTextarea('code','Code','Code',$block->code) }}