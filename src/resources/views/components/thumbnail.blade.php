<div class="form-group">
	@if ($label)
		{{ Form::label($label, null, ['class' => 'control-label']) }}<br>
		<img src="{{$source}}" width="{{$width}}" class="img-thumbnail"><i onMouseOver="this.style.cursor='pointer'" class="fa fa-2x fa-times-circle" id="removeMedia" style="color:red; vertical-align:top; margin-left:1px; margin-top: -14px; background-color: white;"></i>
	@else
    	<img src="{{$source}}" width="{{$width}}" class="img-thumbnail">
    @endif
</div>