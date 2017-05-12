@extends('connexion::templates.backend')

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>System modules</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.settings.index')}}" class="btn btn-primary pull-right">System settings</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-responsive">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Module</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Module</th>
                                    <th>Description</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($modules as $module)
                                    <tr>
                                        <td>
                                            @if ($module->setting_key<>"core_module")
                                                <a title="Click to toggle" href="{{url('/')}}/admin/modules/{{$module->id}}/toggle">
                                            @endif
                                            @if ($module->setting_value=="yes")
                                                <i class="fa fa-check"></i>&nbsp;&nbsp;
                                            @else
                                                <i class="fa fa-times"></i>&nbsp;&nbsp;
                                            @endif
                                            @if ($module->setting_key<>"core_module")
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{strtoupper(str_replace("_"," ",$module->setting_key))}}</td>
                                        <td>{{$module->description}}</td>            
                                    </tr>
                                @empty
                                    <tr><td>No modules have been added yet</td></tr>
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

</script>
@endsection 