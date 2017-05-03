@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop


@section('content_header')
  {{ Form::pgHeader($project->description,'Projects',route('admin.projects.index')) }}
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-6">
                <h4>Leader:
                    @if ($project->individual)
                      {{$project->individual->firstname}} {{$project->individual->surname}}
                    @else
                      No project leader assigned
                    @endif
                </h4>
              </div>
              <div class="col-md-6"><a href="{{route('admin.projects.edit',$project->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit project</a>
            </div>
          </div>
          <div class="panel-body"> 
            <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Completed</th>
                        <th>Assigned to</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Description</th>
                        <th>Completed</th>
                        <th>Assigned to</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($project->actions as $action)
                        <tr>
                            <td><a href="{{route('admin.actions.edit',$action->id)}}">{{$action->description}}</a></td>
                            <td>
                              @if ($action->completed)
                                <a href="{{route('admin.actions.edit',$action->id)}}">{{date("d M Y",$action->completed)}}</a>
                              @endif
                            </td>
                            <td>
                                @if ($action->user->individual)
                                <a href="{{route('admin.actions.edit',$action->id)}}">{{$action->user->individual->firstname}} {{$action->user->individual->surname}}</a>
                                @endif
                            </td>
                            <td><a id="{{$action->id}}" title="Click to mark task as complete" class="toggletask btn btn-xs btn-default">
                              @if ($action->completed)
                                <i class="fa-check fa"></i>
                              @else 
                                <i class="fa-square-o fa"></i>
                              @endif
                            </a></td>
                        </tr>
                    @empty
                        <tr><td>No actions have been added yet</td></tr>
                    @endforelse
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
<script language="javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
      }
  });
  $(document).ready(function() {
    $('#indexTable').DataTable();
    $('.toggletask').on('click',function(){
      $.ajax({
        type : 'GET',
        url : '{{url('/')}}/admin/actions/togglecompleted/' + this.id,
      });
      $(this).find('i').toggleClass('fa-square-o fa-check');
    });
  });
</script>
@stop