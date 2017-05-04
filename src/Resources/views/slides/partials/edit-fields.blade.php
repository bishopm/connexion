{{ Form::bsHidden('slideshow_id',$slide->slideshow_id) }}
{{ Form::bsText('title','Title','Title',$slide->title) }}
{{ Form::bsText('description','Description','Description',$slide->description) }}
{{ Form::bsText('link','Link','Link',$slide->link) }}
{{ Form::bsText('rankorder','Order','Order',$slide->rankorder) }}
{{ Form::bsText('active','Active','Active',$slide->active) }}
{{ Form::bsHidden('image',$slide->image) }}
Required image dimensions - Width: {{$slideshow->width}} Height: {{$slideshow->height}}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>