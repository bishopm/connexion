@extends('connexion::templates.backend')

@section('css')
@if (strpos($setting->setting_key, 'colour')!==false)
    <link href="{{ asset('/vendor/bishopm/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
@endif
@stop

@section('content_header')
{{ Form::pgHeader('Edit setting','Settings',route('admin.settings.index')) }}
@endsection

@section('content')
    
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => ['admin.settings.update',$setting->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::settings.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.settings.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
@if (strpos($setting->setting_key, 'colour')!==false)
<script src="{{ asset('/vendor/bishopm/colorpicker/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
      $("#cp").colorpicker();
    });    
</script>
@endif
@endsection