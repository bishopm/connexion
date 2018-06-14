@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Edit person','persons',route('admin.persons.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.persons.update',$person->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::persons.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.persons.index')) }}
                    <a onclick="deleteboxes();" class="btn btn-danger btn-flat pull-right"><i class="fa fa-trash"></i>Delete person</a>
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
        $('.selectize').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
    });
    function deleteboxes() {
        $('#deletetype').show();
        $('#deletenotes').show();
    }
    $( document ).ready(function() {
        $('.position-input').selectize({
            plugins: ['remove_button'],
            openOnFocus: 1,
            maxOptions: 30,
            onItemAdd: function(value,$item) {
              $.ajax({ url: "{{url('/')}}/admin/persons/{{$person->id}}/addposition/" + value })
            },
            onItemRemove: function(value,$item) {
              $.ajax({ url: "{{url('/')}}/admin/persons/{{$person->id}}/removeposition/" + value })
            }
        });
    });
</script>
@stop