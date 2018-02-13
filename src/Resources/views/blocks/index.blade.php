@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Blocks</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.blocks.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new block</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Block description</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Block description</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($blocks as $block)
                                    <tr>
                                        <td><a href="{{route('admin.blocks.edit',$block->id)}}">{{$block->description}}</a></td>
                                    </tr>                                    
                                @empty
                                    <tr><td>No blocks have been added yet</td></tr>
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