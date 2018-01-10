{{ Form::bsText('jobtitle','Job title','Job title',$employee->jobtitle) }}
{{ Form::bsText('startdate','Start date','Start date',$employee->startdate) }}
{{ Form::bsText('hours','Hours per week','Hours per week',$employee->hours) }}
{{ Form::bsText('leave','Leave per annum','Leave per annum',$employee->leave) }}
{{ Form::bsTextarea('notes','Notes','Notes',$employee->notes) }}
{{ Form::bsHidden('individual_id',$employee->individual_id) }}