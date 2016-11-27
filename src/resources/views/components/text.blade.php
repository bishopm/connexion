<div class="form-group">
	@if ($label)
	    {{ Form::label($label, null, ['class' => 'control-label']) }}
	@endif
    {{ Form::text($name, $value, array_merge(['class' => 'form-control', 'id' => $name, 'placeholder' => $placeholder], $attributes)) }}
</div>