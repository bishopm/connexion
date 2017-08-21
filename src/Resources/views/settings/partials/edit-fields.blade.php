{{ Form::bsText('setting_key','Setting','Setting',$setting->setting_key) }}
@if ($dropdown)
	{{ Form::label('Setting value')}}
	<select class='form-control' name='setting_value' id='setting_value'>
		@foreach ($dropdown as $val)
			@if ($setting->setting_value==$val[0])
				<option selected value="{{$val[0]}}">{{$val[1]}}</option>
			@else
				<option value="{{$val[0]}}">{{$val[1]}}</option>
			@endif
		@endforeach
	</select>
@else
	{{ Form::bsText('setting_value','Setting value','Setting value',$setting->setting_value) }}
@endif
{{ Form::bsText('description','Description','Description',$setting->description) }}