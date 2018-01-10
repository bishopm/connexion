{{ Form::bsText('firstname','First name','First name',$individual->firstname) }}
{{ Form::bsText('surname','Surname','Surname',$individual->surname) }}
@can('admin-backend')
    {{ Form::bsText('slug','Slug','Slug',$individual->slug) }}
@endcan
@cannot('admin-backend')
    {{ Form::bsHidden('slug',$individual->slug) }}
@endcan
{{ Form::bsText('cellphone','Cellphone','Cellphone',$individual->cellphone) }}
{{ Form::bsText('officephone','Office phone','Office phone',$individual->officephone) }}
{{ Form::bsText('email','Email','Email',$individual->email) }}
{{ Form::bsText('birthdate','Date of birth','Date of birth',$individual->birthdate) }}
{{ Form::bsSelect('sex','Sex',array('male','female'),$individual->sex) }}
{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev'),$individual->title) }}
{{ Form::bsSelect('memberstatus','Membership status',array('Member','Non-member','Child','Staff'),$individual->memberstatus) }}
{{ Form::bsHidden('image',$individual->image) }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>
@if ($media<>"webpage")
{{ Form::bsTextarea('notes','Notes','Notes',$individual->notes) }}
@can('admin-giving')
	{{ Form::bsText('giving','Planned Giving','Planned Giving',$individual->giving) }}
@endcan
@endif
{{ Form::bsHidden('household_id',$individual->household_id) }}