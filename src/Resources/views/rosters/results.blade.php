@extends('adminlte::page')

@section('content')

<div class="container-fluid">
  <table class="table">
    <tr><td colspan="2"><b>{{$type}} sent to</b></td></tr>
    @foreach ($results as $result)
      <tr><td><a href="{{url('/')}}/admin/households/{{$result['household']}}">{{$result['name']}}</a></td><td>{{$result['address']}}</td></tr>
    @endforeach
  </table>
</div>
@stop
