@extends('adminlte::page')

@section('htmlheader_title')
    Dashboard household
@endsection

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>{{$household->addressee}}</h4></div>
                            <div class="col-md-6"><a class="btn btn-danger pull-right">Delete</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                    {{$household}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection