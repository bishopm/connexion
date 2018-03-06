@extends('connexion::templates.frontend')

@section('title','Courses at ' . $setting['site_abbreviation'])

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
<div class="container">
<h1>{{$setting['site_abbreviation']}} Courses</h1>
  @include('connexion::shared.errors') 
  <ul class="nav nav-pills" role="tablist">
    <li role="presentation"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab" class="nav-link active">Courses</a></li>
    <li role="presentation"><a href="#homegroups" aria-controls="homegroups" role="tab" data-toggle="tab" class="nav-link">Home group materials</a></li>
    <li role="presentation"><a href="#selfstudy" aria-controls="selfstudy" role="tab" data-toggle="tab" class="nav-link">Self-study</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="courses">
        <div class="table-responsive mt-3">
            <table id="cTable" class="table table-striped table-hover table-condensed" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th><th>Course</th><th>Description</th><th>Average rating (1-5)</th><th>Comments</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th><th>Course</th><th>Description</th><th>Average rating (1-5)</th><th>Comments</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($courses as $cc)
                        <tr>
                            <td><a href="{{route('webresource',$cc->slug)}}"><img width="150px" class="img-responsive" src="{{url('/')}}/storage/courses/{{$cc->image}}"></a></td>
                            <td><a href="{{route('webresource',$cc->slug)}}">{{$cc->title}}</a></td>
                            <td><a href="{{route('webresource',$cc->slug)}}">{!!$cc->description!!}</a></td>
                            <td><a href="{{route('webresource',$cc->slug)}}">{{round($cc->averageRate(),2)}}</a></td>
                            <td><a href="{{route('webresource',$cc->slug)}}">{{count($cc->comments)}}</a></td>
                        </tr>
                    @empty
                        <tr><td>No courses have been added yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="homegroups"><br>
        <table id="hgTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th><th>Course</th><th>Description</th><th>Average rating (1-5)</th><th>Comments</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th><th>Course</th><th>Description</th><th>Average rating (1-5)</th><th>Comments</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($homegroup as $hg)
                    <tr>
                    	<td><a href="{{route('webresource',$hg->slug)}}"><img width="150px" class="img-responsive" src="{{url('/')}}/storage/courses/{{$hg->image}}"></a></td>
                        <td><a href="{{route('webresource',$hg->slug)}}">{{$hg->title}}</a></td>
                        <td><a href="{{route('webresource',$hg->slug)}}">{!!$hg->description!!}</a></td>
                        <td><a href="{{route('webresource',$hg->slug)}}">{{round($hg->averageRate(),2)}}</a></td>
                        <td><a href="{{route('webresource',$hg->slug)}}">{{count($hg->comments)}}</a></td>
                    </tr>
                @empty
                    <tr><td>No home group materials have been added yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="selfstudy"><br>
    	@forelse($selfstudy as $ss)
    		{{$ss}}
    	@empty
    		No self-study courses have been added to the site yet
    	@endforelse
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#cTable').DataTable();
    $('#hgTable').DataTable();
} );
</script>
@endsection