@extends('connexion::templates.backend')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/vendor/bishopm/css/jquery.bootgrid.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader($household->addressee,'Households',route('admin.households.index')) }}
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h4>{{$household->addressee}}</h4>
              </div>
              <div class="col-md-6">
                <a href="{{route('admin.households.edit',$household->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit household</a>
              </div>
            </div>
          </div> <!-- Box header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div>{{$household->physicaladdress}}</div>
                <div>{{$household->postaladdress}}</div>
                @if ($household->homephone)
                  <div><i class="fa fa-phone"></i> {{$household->homephone}}</div>
                @endif
              </div>
              <div class="col-md-6">
                {{Form::bsHidden('latitude',$household->latitude)}}
                {{Form::bsHidden('longitude',$household->longitude)}}
                @if (isset($setting['google_api']))
                    <div id="map_canvas" style="height:200px;">
                    </div>
                @else
                    Google maps has not been set up by your administrator
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                &nbsp;
              </div>
            </div>
            @if (count($household->individuals))
              <div class="nav-tabs-custom well">
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
                      <div class="row">
                        <div class="col-md-12">
                          @if ($individual->sex=="male")
                            <a title="Edit individual" href="{{route('admin.individuals.edit',array($household->id,$individual)) }}"><span class="btn btn-default"><i class="fa fa-fw fa-male"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                          @elseif ($individual->sex=="female")
                            <a title="Edit individual" href="{{route('admin.individuals.edit',array($household->id,$individual)) }}"><span class="btn btn-default"><i class="fa fa-fw fa-female"></i><b>{{$individual->title}} {{$individual->firstname}} {{$individual->surname}}</b></span></i></a>
                          @endif
                        </div>
                        <div class="col-md-6">
                          <div title="Cellphone"><i class="fa fa-fw fa-mobile"></i>{{$individual->cellphone}}</div>
                          <div title="Office phone"><i class="fa fa-fw fa-phone-square"></i>{{$individual->officephone}}</div>
                          <div title="Email"><i class="fa fa-fw fa-envelope-o"></i>{{$individual->email}}</div>
                          <div title="Membership status"><i class="fa fa-fw fa-street-view"></i>{{$individual->memberstatus}}</div>
                          <div title="Notes"><i class="fa fa-fw fa-pencil-square-o"></i>{!! $individual->notes !!}</div>
                          @if ((count($logs)) and (array_key_exists($individual->id, $logs)))
                            <div class="small">{{$logs[$individual->id]}}</div>
                          @endif
                        </div>
                        <div class="col-md-6">
                          @if ($individual->image<>'')
                            {{ Form::bsThumbnail(url('/') . '/storage/individuals/' . $individual->id . '/' . $individual->image,120) }}
                          @else
                            {{ Form::bsThumbnail(url('/') . '/vendor/bishopm/images/profile.png',120) }}
                          @endif
                        </div>
                      </div>
                      <hr>
                      <div class="nav-tabs">
                        <ul id="myGroupTab" class="nav nav-pills">
                          <li class="active">
                            <a href="#g0_{{$individual->id}}" data-toggle="tab">Groups</a>
                          </li>
                          <li>
                            <a href="#g1_{{$individual->id}}" data-toggle="tab">Group History</a>
                          </li>
                          <li>
                            <a href="#g2_{{$individual->id}}" data-toggle="tab">Tags</a>
                          </li>
                        </ul>
                        <div id="myGroupTabContent" class="tab-content">
                          <div class="tab-pane active" id="g0_{{$individual->id}}">
                            <div class="box-default">
                                <div class="box-body">
                                    <h5>{{$individual->firstname}} is currently a member of the following groups:</h5>
                                    <select class="input-groups" multiple>
                                      @foreach ($groups as $group)
                                        @if ((count($individual->groups)) and (in_array($group->id,$igroups[$individual->id])))
                                          <option selected value="{{$individual->id}}/{{$group->id}}">{{$group->groupname}}</option>
                                        @else
                                          <option value="{{$individual->id}}/{{$group->id}}">{{$group->groupname}}</option>
                                        @endif
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
                          <div class="tab-pane" id="g2_{{$individual->id}}">
                            <div class="box-default">
                              <div class="box-body">
                                  <h5>Tags usually refer to specific roles (eg: preacher, staff member)</h5>
                                  <select id="{{$individual->id}}" class="input-tags" multiple>
                                    @foreach ($tags as $tag)
                                      @if ((count($individual->tags)) and (in_array($tag->name,$itags[$individual->id])))
                                        <option selected value="{{$individual->id}}/{{$tag->name}}">{{$tag->name}}</option>
                                      @else
                                        <option value="{{$individual->id}}/{{$tag->name}}">{{$tag->name}}</option>
                                      @endif
                                    @endforeach
                                  </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>  <!-- Nav-tabs-custom -->
                    </div>
                  @endforeach
                </div> <!-- Tab content -->
              </div>
            @else
              <div class="row">
                <div class="col-md-12">
                  <a title="Add an individual" class="btn btn-primary btn-xs" href="{{ route('admin.individuals.create',$household->id) }}">Add an individual to this household</a>
                </div>
              </div>
            @endif
          </div> <!-- Box body -->
        </div> <!-- Box -->
      </div> <!-- First column -->
      <div class="col-md-6">
        <div class="box box-default">
          <div class="box-header">
            <h4>
              Pastoral contact
              @if (count($pastors))
                <button id="addpastoral" class="pull-right btn btn-primary btn-xs">Add</button>
              @else
                <span class="pull-right small">Set up and populate pastoral <a href="{{ route('admin.groups.index') }}">group</a> and update <a href="{{ route('admin.settings.index') }}">settings</a></span>
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
                    <tr><th class="col-sm-6">Date</th><td class="col-sm-6"><input id="pastoraldate" name="pastoraldate"></td></tr>
                    <tr><th class="col-sm-6">Type</th><td class="col-sm-6"><select id="actiontype" name="actiontype"><option>visit</option><option>message</option><option>phone</option></select></td></tr>
                    <tr><th class="col-sm-6">Details</th><td class="col-sm-6"><input id="details" name="details"></td></tr>
                    <tr><th class="col-sm-6">Pastor</th><td class="col-sm-6"><select id="individual_id" name="individual_id">
                      @foreach ($pastors as $pastor)
                        <option value="{{$pastor['id']}}">{{$pastor['firstname']}} {{$pastor['surname']}}</option>
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
                    <tr><th class="col-sm-6">Date</th><td class="col-sm-6"><input id="anniversarydate" name="anniversarydate"></td></tr>
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
      </div> <!-- Second column -->
    </div> <!-- Main row -->
@stop

@section('js')
    @if (isset($setting['google_api']))
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    @endif
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/gmap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/jquery.bootgrid.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/jquery.bootgrid.fa.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
      });
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
        $('.input-tags').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
          dropdownParent: "body",
          create: function(value) {
              var indiv = this.$input[0].id;
              return {
                  value: indiv + '/' + value,
                  text: value
              }
          },
          onItemAdd: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/individuals/addtag/" + value })
          },
          onItemRemove: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/individuals/removetag/" + value })
          }
        });
        google.maps.event.addDomListener(window, 'load', initialize(16));
        $("#pastoraltable").bootgrid({
          ajaxSettings: {
            method: "GET",
            cache: false
          },
          labels: {
            loading: "No pastoral contact has been recorded yet",
            noResults: "No pastoral contact has been recorded"
          },
          ajax: true,
          url: '{{route('admin.pastorals.index',$household->id)}}',
          templates: {
            search: "",
            actions: ""
          }
        }).on("click.rs.jquery.bootgrid", function(e, columns, row){
          $('#myModalLabel').text("Edit pastoral entry");
          $('#newpastoral').hide();
          $('#updatepastoral').show();
          $('#deletepastoral').show();
          $('#pastoralmodal').modal('show');
          $('#pastoraldate').val(row.pastoraldate);
          $('#id').val(row.id);
          $('#actiontype').val(row.actiontype);
          $('#details').val(row.details);
          $('#individual_id').val(row.individual_id);
        });
        $("#specialtable").bootgrid({
          ajaxSettings: {
            method: "GET",
            cache: false
          },
          labels: {
            loading: "No anniversaries have been entered yet",
            noResults: "No anniversaries have been entered"
          },
          ajax: true,
          url: '{{route('admin.specialdays.index',$household->id)}}',
          templates: {
            search: "",
            actions: ""
          }
        }).on("click.rs.jquery.bootgrid", function(e, columns, row){
          $('#myModalLabel2').text("Edit anniversary");
          $('#newspecial').hide();
          $('#updatespecial').show();
          $('#deletespecial').show();
          $('#specialmodal').modal('show');
          $('#anniversarydate').val(row.anniversarydate);
          $('#anniversaryid').val(row.anniversaryid);
          $('#anniversarytype').val(row.anniversarytype);
          $('#anniversarydetails').val(row.anniversarydetails);
        });
      });
      $( document ).ready(function() {
          $(function() {
            $("#pastoraldate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd"
            });
          });
          $(function() {
            $("#anniversarydate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd"
            });
          });
      });
      $('#addpastoral').on('click',function(){
        $('#newpastoral').show();
        $('#updatepastoral').hide();
        $('#deletepastoral').hide();
        $('#myModalLabel').text("Add new pastoral entry");
        $('#pastoralmodal').modal('show');
        $('#id').val('');
        $('#actiontype').val('');
        $('#details').val('');
        $('#individual_id').val('');
      });
      $('#updatepastoral').on('click',function(){
        $.ajax({
            type : 'PUT',
            url : '{{route('admin.pastorals.update',$household->id)}}',
            data : $('#pastoralform').serialize(),
            success: function(){
              $('#pastoralmodal').modal('hide');
              $('#pastoraltable').bootgrid('reload');
            }
        });
      });
      $('#deletepastoral').on('click',function(){
        $.ajax({
            type : 'DELETE',
            url : '{{route('admin.pastorals.destroy',array($household->id,1))}}',
            data : $('#pastoralform').serialize(),
            success: function(){
              $('#pastoralmodal').modal('hide');
              $('#pastoraltable').bootgrid('reload');
            }
        });
      });
      $('#newpastoral').on('click',function(){
        $.ajax({
            type : 'POST',
            url : '{{route('admin.pastorals.store',$household->id)}}',
            data : $('#pastoralform').serialize(),
            success: function(){
              $('#pastoralmodal').modal('hide');
              $('#pastoraltable').bootgrid('reload');
            }
        });
      });
      $('#addspecial').on('click',function(){
        $('#newspecial').show();
        $('#updatespecial').hide();
        $('#deletespecial').hide();
        $('#myModalLabel2').text("Add new special entry");
        $('#specialmodal').modal('show');
        $('#anniversarydate').val('');
        $('#anniversaryid').val('');
        $('#anniversarytype').val('');
        $('#anniversarydetails').val('');
      });
      $('#updatespecial').on('click',function(){
        $.ajax({
            type : 'PUT',
            url : '{{route('admin.specialdays.update',$household->id)}}',
            data : $('#specialform').serialize(),
            success: function(){
              $('#specialmodal').modal('hide');
              $('#specialtable').bootgrid('reload');
            }
        });
      });
      $('#deletespecial').on('click',function(){
        $.ajax({
            type : 'DELETE',
            url : '{{route('admin.specialdays.destroy',array($household->id,1))}}',
            data : $('#specialform').serialize(),
            success: function(){
              $('#specialmodal').modal('hide');
              $('#specialtable').bootgrid('reload');
            }
        });
      });
      $('#newspecial').on('click',function(){
        $.ajax({
            type : 'POST',
            url : '{{route('admin.specialdays.store',$household->id)}}',
            data : $('#specialform').serialize(),
            success: function(){
              $('#specialmodal').modal('hide');
              $('#specialtable').bootgrid('reload');
            }
        });
      });
  </script>
@stop
