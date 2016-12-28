{{ Form::bsText('title','Title','Title',$resource->title) }}
{{ Form::bsText('author','Author / Source','Author / Source', $resource->author) }}
{{ Form::bsTextarea('description','Description','Description',$resource->description) }}
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