@extends('adminlte::page')

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                        @if (isset($user))
                            {{$user}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection