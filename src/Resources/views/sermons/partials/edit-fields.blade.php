{{ Form::bsText('sermon','Sermon title','Sermon title',$sermon->sermon) }}
{{ Form::bsText('slug','Slug','Slug',$sermon->slug) }}
{{ Form::bsText('servicedate','Service date','Service date',$sermon->servicedate) }}
{{ Form::bsText('mp3','Link to mp3','Link to mp3',$sermon->mp3) }}
{{ Form::bsText('readings','Readings','Readings',$sermon->readings) }}
{{ Form::bsText('person_id','Preacher','Preacher',$sermon->person_id) }}
{{ Form::bsHidden('series_id',$series) }}