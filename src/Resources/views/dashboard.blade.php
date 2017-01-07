@extends('adminlte::page')

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>
                    <div class="panel-body">
                        <div class="well col-md-12">
                            Welcome, 
                            @if (isset($currentUser->individual))
                                <b>{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</b>
                            @else
                                <b>{{$currentUser->name}}</b>
                            @endif
                        </div>
                        <div class="well col-md-3">
                        @foreach ($actions as $action)
                            <li>{{$action->description}}</li>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
