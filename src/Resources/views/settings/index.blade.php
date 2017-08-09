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
                            <div class="col-md-6"><h4>Settings</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.modules.index')}}" class="btn btn-primary pull-right"><i class="fa fa-cogs"></i> System modules</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Setting</th><th>Value</th><th>Description</th><th>Module</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Setting</th><th>Value</th><th>Description</th><th>Module</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($settings as $setting)
                                    <tr>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{strtoupper(str_replace('_',' ',$setting->setting_key))}}</a></td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{$setting->setting_value}}</a></td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{$setting->description}}</a></td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{$setting->module}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No settings have been added yet</td></tr>
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