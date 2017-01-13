@extends('app')

@section('content')
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Sets <a href="sets/create" class="btn btn-default">Add a new set</a></h3>
        @include('shared.messageform')
    </div>
    <?php $first=true; ?>
    <div class="box-body">
        <div id="tabs">
            @if ($sets<>"")
                <ul id="myTab" class="nav nav-tabs">
                    @foreach ($sets as $sn=>$set)
                        @if ($first==true)
                            <li class="active"><a href="#{{str_replace(' ','',$sn)}}" data-toggle="tab">{{$sn}}</a></li>
                            <?php $first=false; ?>
                        @else
                            <li><a href="#{{str_replace(' ','',$sn)}}" data-toggle="tab">{{$sn}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <?php $first=true; ?>
                <div id="myTabContent" class="tab-content">
                    @foreach ($sets as $sn2=>$set2)
                        @if ($first==true)
                            <div class="tab-pane active" id="{{str_replace(' ','',$sn2)}}"><br>
                            <?php $first=false; ?>
                        @else
                            <div class="tab-pane" id="{{str_replace(' ','',$sn2)}}"><br>
                        @endif
                            @foreach ($set2 as $sss)
                                <li class="list-unstyled">{!! $sss !!}</li>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                No sets have been created yet
            @endif
        </div>
    </div>
</div>
@stop
