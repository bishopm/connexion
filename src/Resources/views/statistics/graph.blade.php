@extends('connexion::templates.backend')

@section('content')
    <div class="container-fluid spark-screen">
        @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Statistics</small></h4></div>
                            <div class="col-md-6">
                                @if ($nextyr)
                                    <a href="{{url('/')}}/admin/statistics/graph/{{$nextyr}}" class="btn btn-primary pull-right" style="margin-left:5px;">{{$nextyr}}</a>
                                @endif
                                <span class="btn btn-default pull-right" style="margin-left:5px;">{{$thisyr}}</span>
                                @if ($lastyr)
                                    <a href="{{url('/')}}/admin/statistics/graph/{{$lastyr}}" class="btn btn-primary pull-right">{{$lastyr}}</a>
                                @endif
                            </div>
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