{{ Form::bsText('slideshowname','Slideshow name','Slideshow name',$slide->slideshowname) }}
{{ Form::bsText('title','Title','Title',$slide->title) }}
{{ Form::bsText('description','Description','Description',$slide->description) }}
{{ Form::bsText('link','Link','Link',$slide->link) }}
{{ Form::bsText('rankorder','Order','Order',$slide->rankorder) }}
{{ Form::bsText('active','Active','Active',$slide->active) }}
{{ Form::bsHidden('image',$media) }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>