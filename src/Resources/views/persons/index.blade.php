@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Leaders</h4></div>
                            <div class="col-md-6">
                                @if ($persons=="No token")
                                    <a href="{{route('admin.mcsa.register')}}" class="btn btn-primary pull-right">Connect to MCSA database</a>
                                @else
                                    <a href="{{route('admin.persons.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new leader</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Leader</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Leader</th>
                                    <th>Role</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(is_array($persons))
                                    @forelse ($persons as $person)
                                        <tr>
                                            <td><a href="{{route('admin.persons.edit',$person->id)}}">{{$person->surname}}, {{$person->firstname}}</a></td>
                                            <td><a href="{{route('admin.persons.edit',$person->id)}}">
                                            @foreach ($person->positions as $position)
                                                {{$position->position}}@if (!$loop->last), @endif
                                            @endforeach
                                            </a></td>
                                        </tr>
                                    @empty
                                        <tr><td>No persons have been added yet</td></tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@parent
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection