{{ Form::bsText('sermon','Sermon title','Sermon title') }}
{{ Form::bsText('slug','Slug','Slug') }}
{{ Form::bsText('servicedate','Service date','Service date') }}
{{ Form::bsText('mp3','Link to mp3','Link to mp3') }}
{{ Form::bsText('readings','Readings','Readings') }}
{{ Form::bsText('person_id','Preacher','Preacher') }}
{{ Form::bsHidden('series_id',$series_id) }}