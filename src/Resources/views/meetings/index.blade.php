@extends('app')

@section('content')
<div class="box box-default">
    <div class="box-header">
        <h1>{{$year}} Circuit Meetings <small>{{Helpers::getSetting('circuit_name')}} Circuit</small> <a href="{{url('/')}}/meetings/create" class="btn btn-danger">Add new meeting</a></h1>
        <a href="{{url('/')}}/meetings/{{$year-1}}" class="btn btn-danger">{{$year-1}}</a> <a href="{{url('/')}}/meetings/{{$year+1}}" class="btn btn-danger">{{$year+1}}</a>
    </div>
    <div class="box-body">
        <table class="table-condensed table-striped">
            @if (isset($meetings))
                @foreach ($meetings as $meeting)
                    <tr><td>{{date("d M Y G:i",$meeting->meetingdatetime)}}</td><td><a href="{{url('/')}}/meetings/{{$meeting->id}}/edit">{{$meeting->description}}</a></td></tr>
                @endforeach
            @else
                <tr><td>No meetings have been set up for {{$year}}</td></tr>
            @endif
        </table>
    </div>
@stop
