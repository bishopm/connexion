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
                            <div class="col-md-12"><h4>Templates (handle with care!)</h4></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Template</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Template</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($blocks as $block)
                                    <tr>
                                        <td><a onclick="showBlock('{{url('/')}}/vendor/bishopm/blocks/{{$block}}.blade.php');">{{$block}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No blocks have been added yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <a class="btn btn-primary" onclick="saveBlock()">Update block template</a>&nbsp;<input id="blockname">
                        <textarea id="blockeditor" style="width:100%; font-family: 'Courier New'; font-size:10pt;" cols="50" rows="20">
                        </textarea>
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

    function showBlock(file){
        $.ajax({
            url:file,
            success: function (data){
                $('#blockeditor').html(data);
                $('#blockname').val(file);
            }
        });
    }

    function saveBlock(){
        console.log($('#blockname').val());
        console.log($('#blockeditor').html());
        $.ajax({
            type: 'POST',
            url: $('#blockname').val(),
            data: $('#blockeditor').html(),
            success: console.log('all ok')
        });
    }
</script>
@endsection