@extends('connexion::templates.frontend')

@section('title','Books by the same author')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')  
    <div class="container">
      <h3>{{$author}}</h3>
        <div class="row">
            <table id="bTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
              <thead>
                  <tr>
                      <th></th><th>Book</th><th>Copies</th><th>Average rating (1-5)</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th></th><th>Book</th><th>Copies</th><th>Average rating (1-5)</th>
                  </tr>
              </tfoot>
              <tbody>
                  @forelse ($books as $cc)
                      <tr>
                          <td><a href="{{route('webbook',$cc->slug)}}">
                            @if ($cc->image)
                              <img width="50px" class="img-responsive" src="{{url('/')}}/storage/books/{{$cc->image}}">
                            @else
                              <img width="50px" class="img-responsive" src="{{url('/')}}/vendor/bishopm/images/book.png">
                            @endif
                          </a></td>
                          <td><a href="{{route('webbook',$cc->slug)}}">{{$cc->title}}</a></td>
                          <td><a href="{{route('webbook',$cc->slug)}}">{!!$cc->stock!!}</a></td>
                          <td><a href="{{route('webbook',$cc->slug)}}">{{round($cc->averageRate(),2)}} ({{count($cc->comments)}} comments)</a></td>
                      </tr>
                  @empty
                      <tr><td>No books have been added yet</td></tr>
                  @endforelse
              </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#bTable').DataTable();
} );
</script>
@endsection