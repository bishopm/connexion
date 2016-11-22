@extends('adminlte::page')

@section('htmlheader_title')
    Dashboard
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                        User: {{Auth::user()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection