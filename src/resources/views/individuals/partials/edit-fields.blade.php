{{ Form::bsText('firstname','First name','First name',$individual->firstname) }}
{{ Form::bsText('surname','Surname','Surname',$individual->surname) }}
{{ Form::bsText('cellphone','Cellphone','Cellphone',$individual->cellphone) }}
{{ Form::bsText('officephone','Office phone','Office phone',$individual->officephone) }}
{{ Form::bsText('email','Email','Email',$individual->email) }}
{{ Form::bsText('birthdate','Date of birth','Date of birth',$individual->birthdate) }}
{{ Form::bsSelect('sex','Sex',array('male','female'),$individual->sex) }}
{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev'),$individual->title) }}
{{ Form::bsSelect('memberstatus','Membership status',array('Member','Non-member','Child'),$individual->memberstatus) }}
@if (!count($media))
{{ Form::bsFile('image') }}
@else
{{ Form::bsThumbnail($media->getUrl(),100) }}
@endif
{{ Form::bsTextarea('notes','Notes','Notes',$individual->notes) }}
{{ Form::bsHidden('household_id',$individual->household_id) }}