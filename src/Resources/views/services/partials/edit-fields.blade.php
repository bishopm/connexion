{{ Form::bsText('servicetime','Service time','Service time',$service->servicetime) }}
{{ Form::bsSelect('language','Language',array('English','isiZulu'),$service->language) }}
{{ Form::bsTextarea('description','Description','Description',$service->description) }}