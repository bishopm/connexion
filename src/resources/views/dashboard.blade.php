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
                        Logged in to {{$setting['site_name']}} as <b>{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection