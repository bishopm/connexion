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
                            <div class="col-md-6"><h4>Slideshows</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.slideshows.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new slideshow</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Slideshow</th><th>Slides</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Slideshow</th><th>Slides</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($slideshows as $slideshow)
                                    <tr>
                                        <td><a href="{{route('admin.slideshows.show',$slideshow->id)}}">{{$slideshow->slideshow}}</a></td>
                                        <td><a href="{{route('admin.slideshows.show',$slideshow->id)}}">{{count($slideshow->slides)}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No slideshows have been added yet</td></tr>
                                @endforelse
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