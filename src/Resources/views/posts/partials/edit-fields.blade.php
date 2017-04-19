{{ Form::bsText('title','Title','Title',$post->title) }}
{{ Form::bsTextarea('body','Body','Body',$post->body) }}
{{ Form::bsHidden('user_id',$post->user_id)}}