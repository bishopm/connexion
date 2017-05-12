@extends('connexion::templates.backend')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
  {{ Form::pgHeader($group->groupname,'Groups',route('admin.groups.index')) }}
@stop

@section('content')
@include('connexion::shared.errors') 
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary"> 
      <div class="box-header">
        <div class="row">
          <div class="col-md-6">
            <div>{{$group->description}}</div>
          </div>
          <div class="col-md-6">
            <div class="col-md-12">
              <a href="{{route('admin.groups.edit',$group->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit group</a>
            </div>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div><b>Group type:</b> {{$group->grouptype}}</div>
            <div><b>Published on site?:</b>
              @if ($group->publish>0)
                Yes
              @else
                No
              @endif
            </div>
            <div><b>Leader:</b> {{$leader->firstname}} {{$leader->surname}}</div>
          </div>
          <div class="col-md-6">
            {{Form::bsHidden('latitude',$group->latitude)}}
            {{Form::bsHidden('longitude',$group->longitude)}}
            <div id="map_canvas" style="height:200px;"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nav-tabs-custom">
              <ul id="myGroupTab" class="nav nav-tabs">
                <li class="active">
                  <a href="#g0" data-toggle="tab">Current members</a>
                </li>
                <li>
                  <a href="#g1" data-toggle="tab">Previous members</a>
                </li>
              </ul>
              <div id="myGroupTabContent" class="tab-content">
                <div class="tab-pane active" id="g0">
                  <div class="box-default">
                    <div class="box-body">
                      <select class="input-groups" multiple>
                        @foreach ($group->individuals as $indiv)
                          <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                        @endforeach
                        @foreach ($individuals as $individual)
                          <option value="{{$individual->id}}">{{($individual->firstname)}} {{$individual->surname}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="g1">
                  <div class="box-default">
                    <div class="box-body">
                      @foreach ($group->pastmembers as $indiv)
                        @if (!$loop->last)
                          {{$indiv->firstname}} {{$indiv->surname}}, 
                        @else
                          {{$indiv->firstname}} {{$indiv->surname}}.
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{url('/')}}/public/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
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