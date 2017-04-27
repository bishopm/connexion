@extends('adminlte::page')

@section('content')
@include('connexion::shared.errors') 

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h4>Books</h4></div>
                        <div class="col-md-6"><a href="{{route('admin.books.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new book</a></div>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th><th>Stock</th><th>Supplier</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th><th>Stock</th><th>Supplier</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->title}}</a></td>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->stock}}</a></td>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->supplier->supplier}}</a></td>
                                </tr>
                            @empty
                                <tr><td>No books have been added yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
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