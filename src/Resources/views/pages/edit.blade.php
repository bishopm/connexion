@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Edit page','Pages',route('admin.pages.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.pages.update',$page->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::pages.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.pages.index')) }}
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