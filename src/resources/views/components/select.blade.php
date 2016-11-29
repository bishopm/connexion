<div class="form-group">
	@if ($label)
	    {{ Form::label($label, null, ['class' => 'control-label']) }}
	@endif
	<?php
	foreach ($options as $option){
		$finoptions[$option]=$option;
	} ?>
	{{ Form::select($name, $finoptions,$value,array_merge(['class' => 'form-control', 'id' => $name], $attributes)) }}
</div>