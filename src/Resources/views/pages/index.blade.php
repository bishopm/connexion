@extends('adminlte::page')

@section('content') 
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Pages</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.pages.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new page</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Page</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($pages as $page)
                                    <tr>
                                        <td><a href="{{route('admin.pages.edit',$page->id)}}">{{$page->title}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No pages have been added yet</td></tr>
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