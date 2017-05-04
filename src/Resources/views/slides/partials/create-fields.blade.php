{{ Form::bsHidden('slideshow_id',$slideshow->id) }}
{{ Form::bsText('title','Title','Title') }}
{{ Form::bsText('description','Description','Description') }}
{{ Form::bsText('link','Link','Link') }}
{{ Form::bsText('rankorder','Order','Order') }}
{{ Form::bsText('active','Active','Active') }}
{{ Form::bsHidden('image') }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>