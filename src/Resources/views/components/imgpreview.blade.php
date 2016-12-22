<div class="form-group">
	@if ($label)
		{{ Form::label($label, null, ['class' => 'control-label']) }}<br>
		<img src="{{$source}}" width="{{$width}}" class="img-thumbnail"><i onMouseOver="this.style.cursor='pointer'" class="fa fa-2x fa-times-circle" id="removeMedia" style="color:red; vertical-align:top; margin-left:-12px; margin-top:-12px; background-color: transparent;"></i>
	@else
    	<img src="{{$source}}" width="{{$width}}" class="img-thumbnail">
    @endif
</div>