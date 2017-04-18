{{ Form::bsText('addressee','Addressee','Addressee',$household->addressee) }}
{{ Form::bsText('addr1','Residential Address','Residential Address 1',$household->addr1) }}
{{ Form::bsText('addr2','','Residential Address 2',$household->addr2) }}
{{ Form::bsText('addr3','','Residential Address 3',$household->addr3) }}
{{ Form::bsText('post1','Postal Address','Postal Address 1',$household->post1) }}
{{ Form::bsText('post2','','Postal Address 2',$household->post2) }}
{{ Form::bsText('post3','','Postal Address 3',$household->post3) }}
<div class="form-group">
	<label for="Household Cellphone" class="control-label">Household Cellphone</label>
	<select name="householdcell" id="householdcell" class="form-control">
	@if(isset($cellphones))
		@foreach ($cellphones as $key=>$cellphone)
			@if ($household->householdcell==$key)
				<option selected value="{{$key}}">{{$cellphone['name']}}</option>
			@else
				<option value="{{$key}}">{{$cellphone['name']}}</option>
			@endif
		@endforeach
	</select>
	@endif
</div>
{{ Form::bsText('homephone','Home Phone','Home Phone',$household->homephone) }}