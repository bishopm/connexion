@extends('connexion::templates.backend')

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