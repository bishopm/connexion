@extends('adminlte::page')

@section('content')
<div class="container-fluid">
  <div class="panel panel-primary">
    <div class="panel-heading clearfix">
      <big>{{$roster->rostername}}</</big><span class="pull-right"><a title="Edit roster" class="fa fa-edit" href="{{ URL::route('admin.rosters.edit', $roster->id) }}"></a> <a title="Delete roster" class="fa fa-trash" href="{{ URL::route('admin.rosters.destroy', $roster->id) }}"></a></span>
    </div>
    <div class="panel-body">
      <a class="btn btn-default" href="/rosters/{{$roster->id}}/sms_preview" role="button">Prepare SMS messages</a>&nbsp;
      <a class="btn btn-default" href="/rosters/{{$roster->id}}/{{date("Y")-1}}/1" role="button">{{date("Y")-1}}</a>&nbsp;
      <a class="btn btn-default" href="/rosters/{{$roster->id}}/{{date("Y")}}/1" role="button">{{date("Y")}}</a>&nbsp;
      <a class="btn btn-default" href="/rosters/{{$roster->id}}/{{date("Y")+1}}/1" role="button">{{date("Y")+1}}</a>&nbsp;
      <br><br>
      @if (isset($roster->group))
	@foreach ($roster->group as $grp)
	  <a href="{{ URL::to('groups', array($grp->id)) }}">{{$grp->groupname}}</a><br>
	@endforeach
      @endif
    </div>
  </div>
</div>
@stop
