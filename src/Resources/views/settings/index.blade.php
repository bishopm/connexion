@extends('adminlte::page')

@section('content')
@include('base::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Settings</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.settings.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new setting</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Setting</th>
                                    <th>Value</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Setting</th>
                                    <th>Value</th>
                                    <th>Category</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($settings as $setting)
                                    <tr>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{ucfirst(str_replace("_"," ",$setting->setting_key))}}</a></td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{$setting->setting_value}}</a></td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}">{{$setting->category}}</a></td>
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
<script language="javascript">
$(document).ready(function() {
    $('#indexTable').DataTable();
} );
</script>
@endsection 