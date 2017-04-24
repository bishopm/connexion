@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors') 
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
                                    <th>Date</th><th>Title</th><th>Author</th><th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>Title</th><th>Author</th><th>Status</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($blogs as $blog)
                                    <tr>
                                        <td><a href="{{route('admin.blogs.edit',$blog->id)}}">{{date("Y-m-d", strtotime($blog->created_at))}}</a></td>
                                        <td><a href="{{route('admin.blogs.edit',$blog->id)}}">{{$blog->title}}</a></td>
                                        <td><a href="{{route('admin.blogs.edit',$blog->id)}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a></td>
                                        <td><a href="{{route('admin.blogs.edit',$blog->id)}}">{{$blog->status}}</a></td>
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