<div class="form-group">
	@if ($label)
	    {{ Form::label($label, null, ['class' => 'control-label']) }}
	@endif
    {{ Form::password($name, array_merge(['value' => $value, 'class' => 'form-control', 'id' => $name], $attributes)) }}
</div>