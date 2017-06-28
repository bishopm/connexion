@extends('connexion::templates.backend')

@section('content')

<div class="container-fluid">
  <table class="table">
    <tr><td colspan="2"><b>Messages sent to</b></td></tr>
    @foreach ($results as $result)
      <tr><td>{{$result['name']}}</td><td>{{$result['address']}}</td><td>{{$result['emailresult']}}</td></tr>
    @endforeach
  </table>
</div>
@stop
