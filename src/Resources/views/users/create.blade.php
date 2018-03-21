@extends('connexion::templates.backend')

@section('css')
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    {{ Form::pgHeader('Add user','Users',route('admin.users.index')) }}
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.users.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::users.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.users.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.input-individual').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
        $('.input-role').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
          maxOptions: 30,
        });
    });
</script>
@stop 