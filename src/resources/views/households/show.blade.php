@extends('layouts.master')

@section('content-header')
    <h1>
        {{ $household->addressee }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.members.household.index') }}">Households</a></li>
        <li class="active">{{ $household->addressee }}</li>
    </ol>
@stop

@section('styles')
    <link href="{{{ Module::asset('members:css/bootstrap-datepicker.min.css') }}}" rel="stylesheet" type="text/css" />
    <link href="{{{ Module::asset('members:css/jquery.bootgrid.min.css') }}}" rel="stylesheet" type="text/css" />
    <link href="{{{ Module::asset('members:css/members.css') }}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="col-md-6">
                <div class="box-body">
                    @if ($household->addr1<>'')
                        <div>
                            {{$household->addr1}}
                            @if ($household->addr2<>'')
                            ,
                            @endif
                            {{$household->addr2}}
                            @if ($household->addr3<>'')
                            ,
                            @endif
                            {{$household->addr3}}
                        </div>
                    @endif
                    @if ($household->post1<>'')
                        <div>
                            {{$household->post1}}
                            @if ($household->post2<>'')
                            ,
                            @endif
                            {{$household->post2}}
                            @if ($household->post3<>'')
                            ,
                            @endif
                            {{$household->post3}}
                        </div>
                    @endif
                    <br>
                    <a title="Edit household" href="{{route('admin.members.household.edit',$household->id) }}" class="btn btn-primary btn-xs">Edit household</a>
                </div>
            </div>
            @if (!setting('members::googleapi'))
              <div class="col-md-6 box-body" style="height:175px;">Please ask an administrator to enter Google API details to use maps</div>
            @elseif (!$household->latitude)
              <div class="col-md-6 box-body" style="height:175px;">No map co-ordinates have been entered for this household</div>
            @else
              <div class="col-md-6 box-body" id="map_canvas" style="height:175px;"></div>
            @endif
            <div class="col-md-12"><br></div>
            @if (count($household->individual))
                <div class="box-body">
                    <div id="tabs">
                        <div class="nav-tabs">
                            <ul id="myTab" class="nav nav-tabs">
                                @foreach ($household->individual as $key=>$individual)
                                    <li<?php if ($key==0) print " class=\"active\"";?>>
                                        <a href="#k{{ $individual->id }}" data-toggle="tab">{{ $individual->firstname }}</a>
                                    </li>
                                @endforeach
                                <li>
                                    <a title="Add an individual" class="fa fa-plus-square" href="{{ route('admin.members.individual.create',$household->id) }}"></a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                @foreach ($household->individual as $key=>$individual)
                                    <div class="tab-pane<?php if ($key==0) print " active";?>" id="k{{ $individual->id }}">
                                        <div class="box-default">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div>
                                                            @if ($individual->sex=="male")
                                                                <a title="Edit individual" href="{{route('admin.members.individual.edit',$individual->id) }}"><span class="btn btn-default"><i class="fa fa-fw fa-male"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                                                            @elseif ($individual->sex=="female")
                                                                <a title="Edit individual" href="{{route('admin.members.individual.edit',$individual->id) }}"><span class="btn btn-default"><i class="fa fa-fw fa-female"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                                                            @endif
                                                        </div>
                                                        <div title="Cellphone"><i class="fa fa-fw fa-mobile"></i>{{$individual->cellphone}}</div>
                                                        <div title="Office phone"><i class="fa fa-fw fa-phone-square"></i>{{$individual->officephone}}</div>
                                                        <div title="Email"><i class="fa fa-fw fa-envelope-o"></i>{{$individual->email}}</div>
                                                        <div title="Membership status"><i class="fa fa-fw fa-street-view"></i>{{$individual->memberstatus}}</div>
                                                        {!! $individual->notes !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if (count($individual->files))
                                                            <figure>
                                                              <img src="{{str_replace('.','_blogThumb.',$individual->files[0]->pathstring)}}">
                                                            </figure>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nav-tabs-custom">
                                                <ul id="myGroupTab" class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#g0" data-toggle="tab">Groups</a>
                                                    </li>
                                                    <li>
                                                        <a href="#g1" data-toggle="tab">Group History</a>
                                                    </li>
                                                </ul>
                                                <div id="myGroupTabContent" class="tab-content">
                                                    <div class="tab-pane active" id="g0">
                                                        <div class="box-default">
                                                            <div class="box-body">
                                                                @foreach ($individual->groups as $group)
                                                                    <a href="{{route('admin.members.group.show',$group->id)}}">{{$group->groupname}}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="g1">
                                                        <div class="box-default">
                                                            <div class="box-body">
                                                                Group History
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
                </div>
            @else
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a title="Add an individual" class="btn btn-primary btn-xs" href="{{ route('admin.members.individual.create',$household->id) }}">Add an individual to this household</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header">
          <h4>
              Pastoral contact
              @if (count($pastors))
                  <button id="addpastoral" class="pull-right btn btn-primary btn-xs">Add</button>
              @else
                  <span class="pull-right small">Set up and populate pastoral <a href="{{ route('admin.members.group.index') }}">group</a> and update <a href="{{ route('admin.setting.settings.index') }}">settings</a></span>
              @endif
          </h4>
        </div>
        <div class="box-body">
          <table id="pastoraltable" class="table table-condensed table-hover table-striped">
              <thead>
                  <tr>
                      <th data-identifier="true" data-visible="false" data-column-id="id" data-type="numeric">ID</th>
                      <th data-column-id="pastoraldate">Date</th>
                      <th data-column-id="actiontype">Type</th>
                      <th data-column-id="details">Details</th>
                      <th data-column-id="individual_id" data-visible="false" >Individual_id</th>
                      <th data-column-id="pastorname">Pastor</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="pastoralmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
              <form id="pastoralform" method="post">
                <table class="table table-condensed">
                  <input name="id" id="id" type="hidden">
                  <tr><th class="col-sm-6">Date</th><td class="col-sm-6"><input id="pastoraldate" name="pastoraldate" value="{{date('yyyy-mm-dd')}}"></td></tr>
                  <tr><th class="col-sm-6">Type</th><td class="col-sm-6"><select id="actiontype" name="actiontype"><option>visit</option><option>message</option><option>phone</option></select></td></tr>
                  <tr><th class="col-sm-6">Details</th><td class="col-sm-6"><input id="details" name="details"></td></tr>
                  <tr><th class="col-sm-6">Pastor</th><td class="col-sm-6"><select id="individual_id" name="individual_id">
                    @foreach ($pastors as $pastor)
                      <option value="{{$pastor->id}}">{{$pastor->firstname}} {{$pastor->surname}}</option>
                    @endforeach
                  </select></td></tr>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button id="newpastoral" style="display:none" type="button" class="btn btn-primary">Insert</button>
              <button id="deletepastoral" style="display:none" type="button" class="btn btn-danger">Delete</button>
              <button id="updatepastoral" style="display:none" type="button" class="btn btn-primary">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-default">
        <div class="box-header">
          <h4>Anniversaries <button id="addspecial" class="pull-right btn btn-primary btn-xs">Add</button></h4>
        </div>
        <div class="box-body">
          <table id="specialtable" class="table table-condensed table-hover table-striped">
              <thead>
                  <tr>
                      <th data-identifier="true" data-visible="false" data-column-id="id" data-type="numeric">ID</th>
                      <th data-column-id="anniversarydate">Date</th>
                      <th data-column-id="anniversarytype">Type</th>
                      <th data-column-id="anniversarydetails">Details</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="specialmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel2"></h4>
            </div>
            <div class="modal-body">
              <form id="specialform" method="post">
                <table class="table table-condensed">
                  <input name="anniversaryid" id="anniversaryid" type="hidden">
                  <tr><th class="col-sm-6">Date</th><td class="col-sm-6"><input id="anniversarydate" name="anniversarydate" value="{{date('yyyy-mm-dd')}}"></td></tr>
                  <tr><th class="col-sm-6">Type</th><td class="col-sm-6"><select id="anniversarytype" name="anniversarytype"><option>baptism</option><option>death</option><option>wedding</option></select></td></tr>
                  <tr><th class="col-sm-6">Details</th><td class="col-sm-6"><input id="anniversarydetails" name="anniversarydetails"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button id="newspecial" style="display:none" type="button" class="btn btn-primary">Insert</button>
              <button id="deletespecial" style="display:none" type="button" class="btn btn-danger">Delete</button>
              <button id="updatespecial" style="display:none" type="button" class="btn btn-primary">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
  <script src="{{ Module::asset('members:js/moment.js') }}" type="text/javascript"></script>
  @if (setting('members::googleapi'))
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{setting('members::googleapi')}}"></script>
    <script src="{{ Module::asset('members:js/gmap.js') }}" type="text/javascript"></script>
    @if ($household->latitude)
      <script type="text/javascript">google.maps.event.addDomListener(window, 'load', showMap(13,{{$household->latitude}},{{$household->longitude}}));</script>
    @endif
  @endif
@stop
