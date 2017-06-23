@extends('connexion::templates.backend')

@section('css')
    {!! Charts::assets() !!}
@stop

@section('content')
    <div class="container-fluid spark-screen">
        @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Statistics</small></h4></div>
                            <div class="col-md-6"><a href="" class="btn btn-primary pull-right">2017</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            {!! $chart->render() !!}
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection