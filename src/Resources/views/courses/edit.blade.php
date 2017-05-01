@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Edit resource','Courses',route('admin.courses.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.courses.update',$course->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::courses.partials.edit-fields')
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Update</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{route('admin.courses.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'courses'])
@stop

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $( document ).ready(function() {
        $('#title').on('input', function() {
            var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
            $("#slug").val(slug);
        });
    });
    @include('connexion::shared.filemanager-modal-script',['folder'=>'courses','width'=>250,'height'=>250])    
</script>
@endsection