{{ Form::bsText('jobtitle','Job title','Job title') }}
{{ Form::bsText('startdate','Start date','Start date') }}
{{ Form::bsText('hours','Hours per week','Hours per week',40) }}
{{ Form::bsText('leave','Leave per annum','Leave per annum',21) }}
{{ Form::bsTextarea('notes','Notes','Notes') }}
{{ Form::bsHidden('individual_id',$individual->id) }}