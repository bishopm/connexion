@extends('connexion::worship.page')

@section('content')
<div class="box box-default">
    <div class="box-header">
        @include('connexion::shared.errors')
        <ul class="nav nav-pills">
            <li class="active"><a href="#s" data-toggle="tab">Songs ({{$songcount}})</a></li>
            <li><a href="#l" data-toggle="tab">Liturgy ({{$liturgycount}})</a></li>
            <li><a href="#r" data-toggle="tab">Roster</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="s">
            <div class="box-body">
                @foreach($songs as $song)
                    <?php
                        $initlet=substr($song->title, 0, 1);
                        $pagedhouse[$initlet][]="<a class=\"" . $song->musictype . "\" title=\"View song\" href=\"" . url('/') . "/admin/worship/songs/" . $song->id . "\">" . $song->title . "</a>";
                    ?>
                @endforeach
                <ul id="mySubTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#kk" data-toggle="tab">
                            <b class="fa fa-home"></b>
                        </a>
                    </li>
                    @foreach ($lets as $kk=>$vv)
                        <li>
                            <a style="padding-left:7px; padding-right:7px;" href="#k{{$kk}}" data-toggle="tab">
                                @if (isset($pagedhouse[$vv]))
                                    <b>{{$vv}}</b>
                                @else
                                    {{$vv}}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div id="mySubTabContent" class="tab-content">
                    <div class="tab-pane active" id="kk">
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Most recent sets: 
                                @foreach ($mostrecentsets as $mrs)
                                    <span class="label label-default"><a href="{{route('admin.sets.show',$mrs->id)}}">{{$mrs->servicetime}} {{date("d M",strtotime($mrs->servicedate))}}</a></span>
                                @endforeach
                                </h3>
                            </div>
                            <div class="panel-body">
                                @forelse ($newestsets as $kset=>$newset)
                                    <div class="col-sm-4"><h3>{{$kset}}</h3>
                                        <ul class="list-unstyled">
                                            @foreach($newset as $newsong)
                                                <li><a class="{{$newsong['musictype']}}" href="{{url('/')}}/admin/worship/songs/{{$newsong['id']}}">{{$newsong['title']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @empty
                                    No sets have been added yet
                                @endforelse
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Looking for new songs to add? Try <a href="http://www.worshiptogether.com" target="_blank">www.worshiptogether.com</a> or <a href="http://www.worshipcentral.org" target="_blank">worshipcentral.org</a>. For liturgy, try: <a href="https://re-worship.blogspot.com" target="_blank">re-worship.blogspot.com</a>
                            </div>
                            <div class="panel-heading">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#ns" data-toggle="tab">New songs</a></li>
                                    <li><a href="#nh" data-toggle="tab">New hymns</a></li>
                                    <li><a href="#nl" data-toggle="tab">New liturgy</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="ns">
                                        @forelse ($newests as $new)
                                            <div class="col-sm-4">
                                                <a class="contemporary" href="{{url('/')}}/admin/worship/songs/{{$new['id']}}">{{$new->title}}</a>
                                            </div>
                                        @empty
                                            No songs have been added yet
                                        @endforelse
                                    </div>
                                    <div class="tab-pane" id="nh">
                                        @forelse ($newesth as $newh)
                                            <div class="col-sm-4">
                                                <a class="hymn" href="{{url('/')}}/admin/worship/songs/{{$newh['id']}}">{{$newh->title}}</a>
                                            </div>
                                        @empty
                                            No hymns have been added yet
                                        @endforelse
                                    </div>
                                    <div class="tab-pane" id="nl">
                                        @forelse ($newestl as $newl)
                                            <div class="col-sm-4">
                                                <a class="archive" href="{{url('/')}}/admin/worship/songs/{{$newl['id']}}">{{$newl->title}}</a>
                                            </div>
                                        @empty
                                            No liturgies have been added yet
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Most played songs in the last 4 months</h3>
                            </div>
                            <div class="panel-body">
                                @if (isset($recents))
                                    @foreach ($recents as $key=>$services)
                                        <div class="col-sm-4"><h3>{{$key}}</h3>
                                            @foreach ($services as $ss)
                                                @foreach ($ss as $ssf)
                                                    {{$ssf['count']}} <a class="{{$ssf['musictype']}}" href="{{url('/')}}/admin/worship/songs/{{$ssf['id']}}">{{$ssf['title']}}</a><br>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @foreach ($lets as $key=>$let)
                        <div class="tab-pane" id="k{{$key}}">
                            @if (isset($pagedhouse[$let]))
                                <br>
                                <ul class="list-unstyled">
                                    @foreach($pagedhouse[$let] as $thispage)
                                        <li>{!!$thispage!!}</li>
                                    @endforeach
                                </ul>
                            @else
                                <br>
                                <span class="label label-default">There are no songs starting with this letter</span>
                                <br><br>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane" id="l">
            <div class="box-body">
                <ul class="nav nav-pills nav-stacked col-md-2">
                    @foreach ($tags as $key=>$tag)
                        @if ($loop->first)
                            <li class="active">
                        @else
                            <li>
                        @endif
                        <a href="#{{str_replace(' ','-',$key)}}" data-toggle="pill">{{str_replace('-',' ',$key)}} ({{count($tag)}})</a></li>
                    @endforeach
                </ul>
                <div class="tab-content col-md-10">
                    @foreach ($tags as $key=>$tag)
                        @if ($loop->first)
                            <div class="tab-pane active" id="{{str_replace(' ','-',$key)}}">
                        @else
                            <div class="tab-pane" id="{{str_replace(' ','-',$key)}}">
                        @endif
                            <ul class="list-unstyled">
                                @foreach ($tag as $tt)
                                    <li><a href="{{url('/')}}/admin/worship/songs/{{$tt->id}}">{{$tt->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane" id="r">
            <div class="box-header">
                <h4>Click a month for a printable version</h4>
                <ul class="nav nav-pills">
                    @for ($i = 1; $i < 12; $i++)
                        <li>
                            @if (date('n')==$i)
                                <a style="background-color:lightblue;" target="_blank" href="{{url('/')}}/admin/rosters/{{$roster_id}}/report/{{date('Y')}}/{{$i}}">{{date('M',strtotime(date('Y') . '-' . $i . '-' . '01'))}}</a></li>
                            @else
                                <a target="_blank" href="{{url('/')}}/admin/rosters/{{$roster_id}}/report/{{date('Y')}}/{{$i}}">{{date('M',strtotime(date('Y') . '-' . $i . '-' . '01'))}}</a></li>
                            @endif
                    @endfor
                </ul>
            </div>
            <div class="box-body">
                @if (count($roster))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Worship team roster for the next month
                                @if ($fullroster->users->contains($user->id))
                                    <br><b>{{$user->individual->firstname}}, you can edit the roster <a href="{{route('admin.rosters.index')}}">here</a></b>
                                @endif
                            </h3>
                        </div>
                        <div class="panel-body">
                            @foreach ($roster as $rdate=>$rost)
                                <div class="col-sm-12">
                                    <h4>{{date("l, d F Y",$rdate)}}</h4>
                                </div>
                                @foreach ($rost as $indiv=>$groups)
                                    <div class="col-sm-3">
                                        {{$indiv}} <small>(
                                        @foreach ($groups as $group)
                                            @if ($loop->last)
                                                {{$group}}
                                            @else
                                                {{$group}}, 
                                            @endif
                                        @endforeach
                                        )</small>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('js')    
    @include('connexion::worship.partials.scripts')
@stop