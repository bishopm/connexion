@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<div class="container">
    <div class="top30">
        <h1>Explore our bookshop</h1>
    	<table id="bTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th><th>Book</th><th>Author</th><th>Copies</th><th>Average rating (1-5)</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th><th>Book</th><th>Author</th><th>Copies</th><th>Average rating (1-5)</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($books as $cc)
                    <tr>
                        <td><a href="{{route('webbook',$cc->slug)}}"><img width="50px" class="img-responsive" src="{{url('/')}}/storage/books/{{$cc->image}}"></a></td>
                        <td><a href="{{route('webbook',$cc->slug)}}">{{$cc->title}}</a></td>
                        <td><a href="{{route('webbook',$cc->slug)}}">{!!$cc->author!!}</a></td>
                        <td><a href="{{route('webbook',$cc->slug)}}">{!!$cc->stock!!}</a></td>
                        <td><a href="{{route('webbook',$cc->slug)}}">{{$cc->averageRate()}} ({{count($cc->comments)}} comments)</a></td>
                    </tr>
                @empty
                    <tr><td>No books have been added yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#bTable').DataTable();
} );
</script>
@endsection