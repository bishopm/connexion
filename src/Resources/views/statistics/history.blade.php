@extends('connexion::templates.backend')

@section('content')
    <div class="container-fluid spark-screen">
        @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12"><h4>{{$service}} service</h4></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            {!! $chart->container() !!}
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
     {!! $chart->script() !!}
@endsection