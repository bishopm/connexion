@extends('adminlte::page')

@section('content')
    <h1>
        Add a new household
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.households.index') }}">Households</a></li>
        <li class="active">Add a household</li>
    </ol>
    {!! Form::open(['route' => ['admin.households.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class='form-group'>
                        <label for="addressee">Addressee</label>
                        <input class="form-control" placeholder="Addressee" name="addressee" type="text" id="addressee">
                    </div>
                    <div class='form-group'>
                        <label for="addr1">Residential Address</label>
                        <input class="form-control" placeholder="Residential Address 1" name="addr1" type="text" id="addr1">
                    </div>
                    <div class='form-group'>
                        <input class="form-control" placeholder="Residential Address 2" name="addr2" type="text" id="addr2">
                    </div>
                    <div class='form-group'>
                        <input class="form-control" placeholder="Residential Address 3" name="addr3" type="text" id="addr3">
                    </div>
                    <div class='form-group'>
                        <label for="post1">Postal Address</label>
                        <input class="form-control" placeholder="Postal address 1" name="post1" type="text" id="post1">
                    </div>
                    <div class='form-group'>
                        <input class="form-control" placeholder="Postal address 2" name="post2" type="text" id="post2">
                    </div>
                    <div class='form-group'>
                        <input class="form-control" placeholder="Postal address 3" name="post3" type="text" id="post3">
                    </div>
                    <div class='form-group'>
                        <label for="householdcell">Household cellphone</label>
                        <input class="form-control" placeholder="Household cellphone" name="householdcell" type="text" id="householdcell">
                    </div>                    
                    <div class='form-group'>
                        <label for="homephone">Home phone</label>
                        <input class="form-control" placeholder="Home phone" name="homephone" type="text" id="homephone">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">Reset</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.households.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map_canvas" style="height:350px;">
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input class="form-control" placeholder="Latitude" name="latitude" value="" id="latitude" type="text">
                <label for="longtitude">Longitude</label>
                <input class="form-control" placeholder="Longitude" name="longitude" value="" id="longitude" type="text">
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
