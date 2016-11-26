@extends('adminlte::page')

@section('content')
    <h3>
        Add a new setting
    </h3>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="active">Add a setting</li>
    </ol>
    {!! Form::open(['route' => ['admin.settings.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class='form-group'>
                        <label for="setting_key">Setting</label>
                        <input class="form-control" placeholder="Setting" name="setting_key" type="text" id="setting_key">
                    </div>
                    <div class='form-group'>
                        <label for="setting_value">Value</label>
                        <input class="form-control" placeholder="Value" name="setting_value" type="text" id="setting_value">
                    </div>
                    <div class='form-group'>
                        <label for="category">Category</label>
                        <input class="form-control" placeholder="Category" name="category" type="text" id="category">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">Reset</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.settings.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQmfbfWGd1hxfR1sbnRXdCaQ5Mx5FjUhA"></script>
    <script src="{{url('/')}}/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
    </script>
@stop