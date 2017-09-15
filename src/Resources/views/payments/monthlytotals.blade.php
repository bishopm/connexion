@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Giving: ' . $year . ' monthly totals','Payments',route('admin.payments.index')) }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <b>Month</b>
                        </div>
                        <div class="col-xs-4 text-right">
                            <b>Total</b>
                        </div>
                        <div class="col-xs-4 text-right">
                            <b>YTD average</b>
                        </div>
                    </div>
                    @foreach ($data as $key=>$month)
                        <div class="row">
                            <div class="col-xs-4">
                                {{$key}}
                            </div>
                            <div class="col-xs-4 text-right">
                                {{number_format($month['amt'],2)}}
                            </div>
                            <div class="col-xs-4 text-right">
                                {{number_format($month['avg'],2)}}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="box-footer">
                    <a class="btn btn-primary" href="{{url('/')}}/admin/payments/monthtotals/{{$year-1}}">{{$year-1}}</a> 
                    <a class="btn btn-primary" href="{{url('/')}}/admin/payments/monthtotals/{{$year}}">{{$year}}</a> 
                    <a class="btn btn-primary" href="{{url('/')}}/admin/payments/monthtotals/{{$year+1}}">{{$year+1}}</a>
                </div>
            </div>
        </div>
    </div>
@stop