@extends('connexion::templates.backend')

@section('content_header')
{{ Form::pgHeader('Edit setting','Settings',route('admin.settings.index')) }}
@endsection

@section('content')
    
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.settings.extupdate',$setting->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    {{ Form::bsText('setting_key','Setting','Setting',$setting->setting_key) }}
                	{{ Form::bsText('setting_value','Setting value','Setting value',$setting->setting_value) }}
                    {{ Form::bsText('description','Description','Description',$setting->description) }}
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.settings.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop