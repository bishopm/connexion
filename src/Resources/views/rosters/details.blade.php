@extends('app')

@section('content')
<div class="box box-default">
  <div class="box-header">
    @include('shared.messageform')
  	{!! Form::open(['method'=>'post','url'=>'/' . $society . '/rosters/' . $roster->id . '/sms/preview'])!!}
    <h3 class="box-title">{{$roster->rostername}}</h3>
    <a title="Edit roster" class="pull-right btn btn-danger" href="{{ URL::route('society.rosters.edit', array($society,$roster->id)) }}">Edit</a>
    @if (count($extragroups))
      <button type="button" class="pull-right btn btn-danger" data-toggle="modal" data-target="#myModal">Preview SMS messages</button>
      <div class="modal" id="myModal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Extra details needed for SMS messages</h4>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  @foreach ($extragroups as $eg)
                    <div class="col-xs-6">{{$eg->groupname}}</div>
                    <div class="col-xs-6"><input name="extrainfo[{{$eg->id}}]"></div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              {!! Form::submit('Preview messages',array('class'=>'btn btn-danger'))!!}
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
    @else
      {!! Form::submit('Preview messages',array('class'=>'pull-right btn btn-danger'))!!}
    @endif
	</div>
  {!! Form::close()!!}
</div>
<div class="box-body">
	{!! Form::open(['method'=>'post','action'=>['RostersController@revise',$society,$roster->id]])!!}
	@foreach ($months as $num=>$month)
		@if ($num+1==$rostermonth)
			<a class="btn btn-danger" href="{{ url('/') }}/{{$society}}/rosters/{{$roster->id}}/{{$rosteryear}}/{{$num+1}}" role="button">{{$month}}</a>&nbsp;
		@else
			<a class="btn btn-danger" href="{{ url('/') }}/{{$society}}/rosters/{{$roster->id}}/{{$rosteryear}}/{{$num+1}}" role="button">{{$month}}</a>&nbsp;
		@endif
	@endforeach
	<span class="pull-right">
    <a href="{{Helpers::makeUrl(strtolower($socname),"rosters/" . $roster->id . "/report/" . $rosteryear . "/" . $rostermonth)}}" class="btn btn-danger">Report</a>
    <input type="submit" class="btn btn-danger" name="updateme" value="Update roster">
  </span>
	{!! Form::hidden('roster_id',$roster->id)!!}
	<br><br>
	<table class="table table-striped table-condensed">
	@foreach ($weeks as $key=>$week)
    <tr class="default"><td><b>{{$rosteryear}}</b></td>
      @foreach ($groupheadings as $groupheading)
        @if (substr($groupheading,0,1)=="_")
          <td class="text-center">{{substr($groupheading,1)}}</td>
        @else
          <td class="text-center">{{$groupheading}}</td>
        @endif
      @endforeach
    </tr>
		<tr><td><h4><span class="label label-danger">{{date("j M",strtotime($key))}}</span></h4></td>
		@foreach ($groupheadings as $gh)
			<td>
			@if (array_key_exists($gh,$week['#!@']))
				@for ($j = 1; $j < 3; $j++)
					@if (($j==1) or (($j==2) and (in_array($week['#!@'][$gh][$j]['group_id'],$multigroups))))
						{!! Form::hidden('group_id[]',$week['#!@'][$gh][$j]['group_id'])!!}
						{!! Form::hidden('rosterdate[]',$key)!!}
						{!! Form::hidden('selectnum[]', $j)!!}
						@if (isset($week['#!@'][$gh][$j]['individual_id']))
							{!! Form::select('individual_id[]',$groupmembers[$week['#!@'][$gh][$j]['group_id']],$week['#!@'][$gh][$j]['individual_id'],array('class' => 'form-control')) !!}
						@elseif (isset($week['#!@'][$gh][$j]['group_id']))
							{!! Form::select('individual_id[]',$groupmembers[$week['#!@'][$gh][$j]['group_id']],null,array('class' => 'form-control')) !!}
						@endif
					@endif
				@endfor
			@endif
			</td>
		@endforeach
		</tr>
		@foreach ($week as $ttt=>$timeslot)
			@if ($ttt<>"#!@")
				<tr><td>{{$ttt}}</td>
				@foreach ($timeslot as $gkey=>$group)
					<td>
					@for ($i = 1; $i < 3; $i++)
						@if (($i==1) or (($i==2) and (in_array($group[$i]['group_id'],$multigroups))))
							{!! Form::hidden('group_id[]',$group[$i]['group_id'])!!}
							{!! Form::hidden('rosterdate[]',$key)!!}
							{!! Form::hidden('selectnum[]', $i)!!}
							@if (isset($group[$i]['individual_id']))
								{!! Form::select('individual_id[]',$groupmembers[$group[$i]['group_id']],$group[$i]['individual_id'],array('class' => 'form-control')) !!}
							@else
								{!! Form::select('individual_id[]',$groupmembers[$group[$i]['group_id']],null,array('class' => 'form-control')) !!}
							@endif
						@endif
					@endfor
					</td>
				@endforeach
				</tr>
			@endif
		@endforeach
		</tr>
	@endforeach
	{!! Form::close() !!}
</div>
@stop
