@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    {{ Form::pgHeader($household->addressee,'Households',route('admin.households.index')) }}
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{$household->addressee}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.households.edit',$household->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit household</a>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div>{{$household->physicaladdress}}</div>
                <div>{{$household->postaladdress}}</div>
                <div><i class="fa fa-phone"></i> {{$household->homephone}}</div>
              </div>
              <div class="col-md-6">
                <div id="map_canvas" style="height:200px;">
                  {{Form::bsHidden('latitude',$household->latitude)}}
                  {{Form::bsHidden('longitude',$household->longitude)}}
                </div>
              </div>
            </div>
            @if (count($household->individuals))
              <div id="tabs">
                <div class="nav-tabs">
                  <ul id="myTab" class="nav nav-tabs">
                    @foreach ($household->individuals as $key=>$individual)
                      <li<?php if ($key==0) print " class=\"active\"";?>>
                        <a href="#k{{ $individual->id }}" data-toggle="tab">{{ $individual->firstname }}</a>
                      </li>
                    @endforeach
                    <li>
                      <a title="Add an individual" class="fa fa-plus-square" href="{{ route('admin.individuals.create',$household->id) }}"></a>
                    </li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    @foreach ($household->individuals as $key=>$individual)
                      <div class="tab-pane<?php if ($key==0) print " active";?>" id="k{{ $individual->id }}">
                        <div class="box-default">
                          <div class="box-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div>
                                  @if ($individual->sex=="male")
                                    <a title="Edit individual" href="{{route('admin.individuals.edit',array($household->id,$individual)) }}"><span class="btn btn-default"><i class="fa fa-fw fa-male"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                                  @elseif ($individual->sex=="female")
                                    <a title="Edit individual" href="{{route('admin.individuals.edit',array($household->id,$individual)) }}"><span class="btn btn-default"><i class="fa fa-fw fa-female"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                                  @endif
                                </div>
                                <div title="Cellphone"><i class="fa fa-fw fa-mobile"></i>{{$individual->cellphone}}</div>
                                <div title="Office phone"><i class="fa fa-fw fa-phone-square"></i>{{$individual->officephone}}</div>
                                <div title="Email"><i class="fa fa-fw fa-envelope-o"></i>{{$individual->email}}</div>
                                <div title="Membership status"><i class="fa fa-fw fa-street-view"></i>{{$individual->memberstatus}}</div>
                                {!! $individual->notes !!}
                              </div>
                              <div class="col-md-6">
                                <figure>Image goes here</figure>
                              </div>
                            </div>
                          </div>
                          <div class="nav-tabs-custom">
                            <ul id="myGroupTab" class="nav nav-tabs">
                              <li class="active">
                                <a href="#g0_{{$individual->id}}" data-toggle="tab">Groups</a>
                              </li>
                              <li>
                                <a href="#g1_{{$individual->id}}" data-toggle="tab">Group History</a>
                              </li>
                            </ul>
                            <div id="myGroupTabContent" class="tab-content">
                              <div class="tab-pane active" id="g0_{{$individual->id}}">
                                <div class="box-default">
                                  <div class="box-body">
                                    <select class="input-groups" multiple>
                                      @foreach ($individual->groups as $group)
                                        <option selected value="{{$individual->id}}/{{$group->id}}">{{$group->groupname}}</option>
                                      @endforeach
                                      @foreach ($groups as $group)
                                        <option value="{{$individual->id}}/{{$group->id}}">{{$group->groupname}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane" id="g1_{{$individual->id}}">
                                <div class="box-default">
                                  <div class="box-body">
                                    @foreach ($individual->pastgroups as $group)
                                      {{$group->groupname}}
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-md-12">
                  <a title="Add an individual" class="btn btn-primary btn-xs" href="{{ route('admin.individuals.create',$household->id) }}">Add an individual to this household</a>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{url('/')}}/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.input-groups').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              onItemAdd: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/individuals/addgroup/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/individuals/removegroup/" + value })
              }
            });
            google.maps.event.addDomListener(window, 'load', initialize(16));
        });
    </script>
@stop