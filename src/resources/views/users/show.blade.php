@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>User</h4></div>
                            <div class="col-md-6"><a href="" class="btn btn-primary pull-right">Add</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                    {{$user}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
