@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add page','Pages',route('admin.pages.index')) }}
@stop

@section('content')
    @include('base::shared.errors')
    {!! Form::open(['route' => array('admin.pages.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::pages.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.pages.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script langugage="javascript">
$(document).ready(function()
{
    $('#title').on('input', function() {
        var title = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
        $("#slug").val(title);
    });
});
</script>
@stop