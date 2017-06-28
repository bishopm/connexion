@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content_header')
{{ Form::pgHeader('Edit supplier','Suppliers',route('admin.suppliers.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.suppliers.update',$supplier->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::suppliers.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.suppliers.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12"><h3>Current stock</h3></div>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th><th>Author</th><th>Stock</th><th>Cost price</th><th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th><th>Author</th><th>Stock</th><th>Cost price</th><th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->title}}</a></td>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->author}}</a></td>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->stock}}</a></td>
                                    <td><a href="{{route('admin.books.edit',$book->id)}}">{{$book->costprice}}</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.books.edit', [$book->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                            @can('admin-backend')
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-action-entity="Book" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.books.destroy', [$book->id]) }}"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td>We have none of this supplier's stock at present</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('connexion::shared.delete-modal')
@stop

@section('js')
@parent
<script language="javascript">
@include('connexion::shared.delete-modal-script')
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection