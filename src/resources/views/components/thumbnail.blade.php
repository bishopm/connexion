<div class="form-group">
	@if ($label)
		{{ Form::label($label, null, ['class' => 'control-label']) }}<br>
		<img src="{{$source}}" width="{{$width}}" class="img-circle img-thumbnail"><i onMouseOver="this.style.cursor='pointer'" class="fa fa-2x fa-times-circle" id="removeMedia" style="color:red; vertical-align:top; margin-left:-12px; margin-top:-2px; background-color: white;"></i>
	@else
    	<img src="{{$source}}" width="{{$width}}" class="img-circle img-thumbnail">
    @endif
</div>