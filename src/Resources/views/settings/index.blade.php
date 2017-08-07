@extends('connexion::templates.backend')

@section('content')
<div class="container-fluid">
@include('connexion::shared.errors') 
</div>
    <div class="container-fluid spark-screen">
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
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($settings as $tab=>$tabset)
                                @if ($loop->first)
                                    <li role="presentation" class="active">
                                @else
                                    <li role="presentation">
                                @endif
                                <a href="#tab_{{$loop->index}}" aria-controls="home" role="tab" data-toggle="tab">{{ucfirst($tab)}}</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($settings as $category=>$setting)
                                @if ($loop->first)
                                    <div role="tabpanel" class="tab-pane active" id="tab_{{$loop->index}}">
                                @else
                                    <div role="tabpanel" class="tab-pane" id="tab_{{$loop->index}}">
                                @endif
                                <table class="table table-responsive table-striped">
                                    <colgroup>
                                        <col class="col-md-3">
                                        <col class="col-md-3">
                                        <col class="col-md-6">
                                    </colgroup>
                                    <tr>
                                        <th>
                                            Setting
                                        </th>
                                        <th>
                                            Value
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                    </tr>
                                    @foreach ($setting as $sett)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.settings.edit',$sett->id)}}">{{ucwords(str_replace("_"," ",$sett->setting_key))}}</a>
                                            </td>
                                            <td>
                                                <a href="{{route('admin.settings.edit',$sett->id)}}">{{$sett->setting_value}}</a>
                                            </td>
                                            <td>
                                                <a href="{{route('admin.settings.edit',$sett->id)}}">{{$sett->description}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection