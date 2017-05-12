@extends('adminlte::page')

@section('css')
	<meta id="token" name="token" value="{{csrf_token()}}">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
	@yield('content')
@stop

@section('js')
	<script src="//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
@stop