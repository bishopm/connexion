@extends('connexion::templates.frontend')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>User forum</h4></div>
                            <div class="col-md-6"><a href="{{route('posts.create')}}" class="btn btn-primary float-right"><i class="fa fa-pencil"></i> Add a new post</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Replies</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Replies</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td><a href="{{route('posts.show',$post->id)}}">{{date("d M Y H:i",strtotime($post->created_at))}}</a></td>
                                        <td><a href="{{route('posts.show',$post->id)}}">{{$post->title}}</a></td>
                                        <td><a href="{{route('posts.show',$post->id)}}">{{$post->user->individual->firstname}} {{$post->user->individual->surname}}</a></td>
                                        <td><a href="{{route('posts.show',$post->id)}}">{{$post->replies}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No forum posts have been created yet</td></tr>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#indexTable').DataTable();
} );
</script>
@endsection