@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
@stop

@section('content_header')
    {{ Form::pgHeader('Add household member','Individuals',route('admin.households.show',$household)) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.individuals.store',$household), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::individuals.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.households.show',$household)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{asset('/vendor/bishopm/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(function () {
        $("#birthdate").datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endsection