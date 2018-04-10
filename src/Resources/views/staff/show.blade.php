@extends('connexion::templates.backend')

@section('css')
  @parent
  <link href="{{ asset('/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop


@section('content_header')
  {{ Form::pgHeader($staff->firstname . ' ' . $staff->surname,'All staff',route('admin.staff.index')) }}
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-12">
                <h4><a href="{{route('admin.individuals.edit',array($staff->household_id,$staff->id))}}">{{$staff->firstname}} {{$staff->surname}} <small>Click to edit contact details</small></a></h4>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <table class="table no-border">
              @if ($staff->employee)
                <tr><th>Job title</th><td>{{$staff->employee->jobtitle}}</td></tr>
                <tr><th>Started on</th><td>{{$staff->employee->startdate}}</td></tr>
                <tr><th>Hours per week</th><td>{{$staff->employee->hours}}</td></tr>
                <tr><th>Leave per annum</th><td>{{$staff->employee->leave}}</td></tr>
                <tr><th>Notes</th><td>{{$staff->employee->notes}}</td></tr>
                <tr><th></th><td><a class="btn btn-primary" href="{{route('admin.staff.edit',$staff->employee->id)}}">Edit</a></td></tr>
              @else
                <a href="{{route('admin.staff.create',$staff->id)}}">Add employee data</a>
              @endif
            </table>
            @if ($staff->employee)
              <h3 class="text-center">Leave taken during {{$thisyr}} <a title="Record leave dates" href="#" class="btn btn-primary" data-toggle="modal" data-target="#leaveModal">+</a></h3>
              <div class="row">
                <div class="col-xs-2 text-bold text-center">Annual</div>
                <div class="col-xs-2 text-bold text-center">Family</div>
                <div class="col-xs-2 text-bold text-center">Sabbatical</div>
                <div class="col-xs-2 text-bold text-center">Sick</div>
                <div class="col-xs-2 text-bold text-center">Study</div>
                <div class="col-xs-1 text-bold text-center">Unknown</div>
                <div class="col-xs-1 text-bold text-center">Unpaid</div>
                <div class="col-xs-2 text-center">
                  @if (isset($leaveyear['annual']))
                    {{$leaveyear['annual']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-2 text-center">
                  @if (isset($leaveyear['family']))
                    {{$leaveyear['family']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-2 text-center">
                  @if (isset($leaveyear['sabbatical']))
                    {{$leaveyear['sabbatical']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-2 text-center">  
                  @if (isset($leaveyear['sick']))
                    {{$leaveyear['sick']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-2 text-center">
                  @if (isset($leaveyear['study']))
                    {{$leaveyear['study']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-1 text-center">
                  @if (isset($leaveyear['unknown']))
                    {{$leaveyear['unknown']['total']}}
                  @else
                    -
                  @endif
                </div>
                <div class="col-xs-1 text-center">
                  @if (isset($leaveyear['unpaid']))
                    {{$leaveyear['unpaid']['total']}}
                  @else
                    -
                  @endif
                </div>                
              </div>
              <div><hr></div>
              <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th><th>Type</th><th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($yrleave as $ld)
                    <tr>
                      <td>{{$ld->leavedate}}</td>
                      <td>{{$ld->leavetype}}</td>
                      <td><a href="#" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div>
      </div>
    </div>
    @include('connexion::shared.leave-modal')
@stop

@section('js')
@parent
<script src="{{ asset('/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#indexTable').DataTable();
        $('#datepicker').datepicker({
            multidate: true,
            format: "yyyy-mm-dd",
            datesDisabled: {!!$leavedates!!}
        }).on('changeDate', function(e) {
            $(this).find('.input-group-addon .count').text(' ' + e.dates.length);
        });
    });
</script>
@stop