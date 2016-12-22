{{ Form::bsText('slideshowname','Slideshow name','Slideshow name',$slide->slideshowname) }}
{{ Form::bsText('title','Title','Title',$slide->title) }}
{{ Form::bsText('description','Description','Description',$slide->description) }}
{{ Form::bsText('link','Link','Link',$slide->link) }}
{{ Form::bsText('rankorder','Order','Order',$slide->rankorder) }}
{{ Form::bsText('active','Active','Active',$slide->active) }}
@if (!count($media))
{{ Form::bsFile('image') }}
@else
<div id="thumbdiv">
	{{ Form::bsImgpreview($media->getUrl(),300,'Image') }}
</div>
<div id="filediv" style="display:none;">
	{{ Form::bsFile('image') }}
</div>
@endif