{{ Form::bsText('series','Series name','Series name',$series->series) }}
{{ Form::bsText('slug','Slug','Slug',$series->slug) }}
{{ Form::bsText('description','Description','Description',$series->description) }}
@if (!count($media))
{{ Form::bsFile('image') }}
@else
<div id="thumbdiv">
	{{ Form::bsImgpreview($media->getUrl(),250,'Image') }}
</div>
<div id="filediv" style="display:none;">
	{{ Form::bsFile('image') }}
</div>
@endif