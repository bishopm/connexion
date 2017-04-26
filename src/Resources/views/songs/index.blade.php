@extends('connexion::worship.page')

@section('content')
    <div class="box box-default">
      <div class="box-header">
        @include('connexion::shared.errors')
        <h3 class="box-title">Find by title below or use the search box</h3>
      </div>
      <div class="box-body">
        @foreach($songs as $song)
        	<?php
                $initlet=substr($song->title,0,1);
        		$pagedhouse[$initlet][]="<a title=\"View song\" href=\"" . url('/') . "/admin/worship/songs/" . $song->id . "\">" . $song->title . "</a>";
            ?>
        @endforeach
        <div id="tabs">
          <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#kk" data-toggle="tab"><b class="fa fa-home"></b></a></li>
            @foreach ($lets as $kk=>$vv)
                <li><a style="padding-left:7px; padding-right:7px;" href="#k{{$kk}}" data-toggle="tab">
                @if (isset($pagedhouse[$vv]))
                  <b>{{$vv}}</b>
                @else
                  {{$vv}}
                @endif
                </a></li>
            @endforeach
          </ul>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane active" id="kk">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Most recent sets ({{$mostrecentset}})</small></h3>
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
                        <h3 class="panel-title">Recently added <small>Total songs: {{$songcount}}</small></h3>
                    </div>
                    <div class="panel-body">
                        @forelse ($newest as $new)
                            <div class="col-sm-4">
                                <?php /*$ago=round((strtotime("now") - strtotime($new->created_at))/86400);
                                if ($ago>1) {
                                    $ago=$ago . " days ago";
                                } elseif ($ago==1) {
                                    $ago=$ago . " day ago";
                                } else {
                                    $ago="<1 day ago";
                                }*/
                                ?>
                                <a class="{{$new->musictype}}" href="{{url('/')}}/admin/worship/songs/{{$new['id']}}">{{$new->title}}</a>
                            </div>
                        @empty
                            No songs have been added yet
                        @endforelse
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Most played songs in the last quarter</h3>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Most recent user logins</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                          @foreach ($users as $user)
                              <div class="col-sm-3">
                                {{$user->name}}
                              </div>
                          @endforeach
                        </div>
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
    </div>
  </div>
@stop

@section('js')    
    @include('connexion::worship.partials.scripts')
@stop