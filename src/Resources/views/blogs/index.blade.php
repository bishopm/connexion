@extends('adminlte::page')

@section('content')
@include('base::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Blog</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.blogs.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new post</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($blogs as $blog)
                                    <tr>
                                        <td><a href="{{route('admin.blogs.edit',$blog->id)}}">{{$blog->title}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No posts have been added yet</td></tr>
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
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection