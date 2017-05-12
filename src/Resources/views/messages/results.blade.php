@extends('adminlte::page')

@section('content')

<div class="container-fluid">
  <table class="table">
    <tr><td colspan="2"><b>Messages sent to</b></td></tr>
    @foreach ($recipients as $indiv)
      <tr><td>{{$indiv['name']}}</td><td>{{$indiv['email']}}</td><td>{{$indiv['cellphone']}}</td></tr>
    @endforeach
  </table>
</div>
@stop
