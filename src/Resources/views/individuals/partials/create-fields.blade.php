{{ Form::bsText('firstname','First name','First name') }}
{{ Form::bsText('surname','Surname','Surname') }}
{{ Form::bsText('cellphone','Cellphone','Cellphone') }}
{{ Form::bsText('officephone','Office phone','Office phone') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsText('birthdate','Date of birth','Date of birth') }}
{{ Form::bsSelect('sex','Sex',array('male','female')) }}
{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev')) }}
{{ Form::bsSelect('memberstatus','Membership status',array('Member','Non-member','Child')) }}
{{ Form::bsFile('image') }}
{{ Form::bsTextarea('notes','Notes','Notes') }}
{{ Form::bsHidden('household_id',$household) }}