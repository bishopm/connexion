{{ Form::bsText('firstname','First name','First name') }}
{{ Form::bsText('surname','Surname','Surname') }}
{{ Form::bsText('slug','Slug','Slug') }}
{{ Form::bsText('cellphone','Cellphone','Cellphone') }}
{{ Form::bsText('officephone','Office phone','Office phone') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsText('birthdate','Date of birth','Date of birth') }}
{{ Form::bsSelect('sex','Sex',array('male','female')) }}
{{ Form::bsSelect('title','Title',array('Mr','Mrs','Ms','Dr','Rev')) }}
{{ Form::bsSelect('memberstatus','Membership status',array('Member','Non-member','Child','Staff')) }}
@if ((isset($media)) and ($media=="webpage"))
	{{ Form::bsHidden('household_id',$household->id) }}
@else
	{{ Form::bsHidden('image') }}
	{{ Form::label('Image', null, ['class' => 'control-label']) }}
	<div id="thumbdiv" style="margin-bottom:5px;"></div>
	<div id="filediv"></div>
	{{ Form::bsTextarea('notes','Notes','Notes') }}
	{{ Form::bsHidden('household_id',$household->id) }}
	@can('edit-backend')
		{{ Form::bsText('giving','Planned Giving','Planned Giving') }}
	@endcan
@endif
