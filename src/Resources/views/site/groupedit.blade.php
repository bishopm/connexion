@extends('connexion::templates.webpage')

@section('css')
    <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit a group','Groups',route('admin.groups.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => ['admin.groups.update',$group->id], 'method' => 'put']) !!}
    <div class="container">
        <div class="row top30">
            <div class="col-md-6">
                <div class="box box-primary"> 
                    <div class="box-body">
                        <h2>{{$group->groupname}} <small>Leader page</small></h2>
                        <p class="top10">Only the group leader can see this page. Here you can change details about the group, as well as add or remove group members.</p>
                        <hr>
                        @include('connexion::groups.partials.edit-fields',['webedit' => 'true'])
                        <h4>Current members</h4>
                        <select class="input-groups" multiple>
                            @foreach ($group->individuals as $indiv)
                              <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                            @endforeach
                            @foreach ($individuals as $individual)
                              <option value="{{$individual->id}}">{{($individual->firstname)}} {{$individual->surname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Update</button>
                        <a class="btn btn-default btn-flat" href="{{url('/')}}/group/{{$group->slug}}"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                </div>                
            </div>
            <div class="col-md-6">
                <div id="map_canvas" style="height:350px;">
                </div>
                {{ Form::bsText('latitude','Latitude','Latitude',$group->latitude) }}
                {{ Form::bsText('longitude','Longitude','Longitude',$group->longitude) }}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{url('/')}}/public/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>    
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
        $( document ).ready(function() {
            $('.input-groups').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              onItemAdd: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/groups/{{$group->id}}/addmember/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/groups/{{$group->id}}/removemember/" + value })
              }
            });
            google.maps.event.addDomListener(window, 'load', initialize(16));
        });
    </script>
@stop