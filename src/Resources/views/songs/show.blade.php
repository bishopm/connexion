@extends('base::worship.page')

@section('content')

<div id="tabs">
    <div class="nav-tabs-custom">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active">
                <a href="#k0" data-toggle="tab" v-on:click="getMe">View song</a>
            </li>
            <li>
                <a href="#k1" data-toggle="tab" v-on:click="loadPdf">Chords (PDF)</a>
            </li>
            <li>
                <a href="#k2" data-toggle="tab">Edit</a>
            </li>
            <li v-if="history">
                <a href="#k3" data-toggle="tab">History</a>
            </li>
            <li v-if="formdata.video">
                <a href="#k4" data-toggle="tab" v-on:click="loadVideo">Video</a>
            </li>
            <li>
                <a href="#k5" data-toggle="tab">OpenLP</a>
            </li>
            @if ($song->music)
                <li><a target="_blank" href="http://{{$song->music}}">Sheet music</a></li>
            @endif
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active" id="k0">
                <h2>{{$song->title}} <small>{{$song->author}} ({{$song->key}} | {{$song->tempo}})</small></h2>
                @if ($song->audio)
                    <audio preload="none" controls="" width="250px" height="30px" src="http://{{$song->audio}}"></audio>
                    <script>
                        jQuery(document).ready(function($) {
                            $('audio').mediaelementplayer({
                                features: ['playpause','progress','tracks','volume'],
                            });
                        });
                    </script>
                @endif
                <div>
                @foreach ($chords as $chord)
                    @if (isset($chord['id']))
                        <a href="{{url('/')}}/chords/{{$chord['id']}}/edit"><img width="45" src="{{url('/')}}/public/images/chords/{{$chord['id']}}.png"></a>
                    @else
                        <a href="{{url('/')}}/chords/create/{{str_replace('/','_',str_replace('#','^',$chord))}}">{{$chord}}</a>
                    @endif
                @endforeach
                </div>
                <br>
                <song>
                    <div v-html="brlyrics"></div>
                </song>
                <br>
            </div>
            <div class="tab-pane" id="k1">
                <iframe v-if="pdfsource" id="pdfdoc" type="text/html" width="100%" height="600" :src="pdfsource"
                  frameborder="0"/>
                </iframe>
            </div>
            <div class="tab-pane" id="k2">
                <div class="box box-default">
                    <div class="box-header with-border">
                        @include('base::shared.errors')
                        <form method="POST" v-on:submit.prevent>
                            <input type="hidden" name="_token" class="form-horizontal" value="{{ csrf_token() }}">
                            <h1>{{$song->title}}</h1>
                            <button v-on:click="updateMe" type="submit" class="btn btn-default">Update song</button>
                            <button v-on:click="transposeUp" type="submit" class="btn btn-default" name="transpose">Up</button>
                            <button v-on:click="transposeDown" type="submit" class="btn btn-default" name="transpose">Down</button>
                            @include('base::songs.form', array('is_new'=>false))
                        </form>
                    </div>
                    <div class="box-footer">
                        {!! Form::open(['method'=>'delete','style'=>'display:inline;','route'=>['admin.songs.destroy', $song->id]]) !!}
                        {!! Form::submit('Delete',array('class'=>'btn btn-default','onclick'=>'return confirm("Are you sure you want to delete this song?")')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="k3">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">{{$song->title}} <span class="small">Recent history</span></h3>
                    </div>
                    <div class="box-body">
                        @if (isset($history))
                            <?php $count=0; ?>
                            <div class="nav-tabs-custom">
                                <ul id="hTab" class="nav nav-tabs">
                                    @foreach ($history as $key=>$hist)
                                        @if ($count==0)
                                            <li class="active">
                                        @else
                                            <li>
                                        @endif
                                        <a href="#h{{$count}}" data-toggle="tab">{{$key}}</a></li>
                                        <?php $count++;?>
                                    @endforeach
                                </ul>
                                <?php $count2=0; ?>
                                <div id="hTabContent" class="tab-content">
                                    @foreach ($history as $key2=>$hist2)
                                        @if ($count2==0)
                                            <div class="tab-pane active" id="h{{$count2}}">
                                        @else
                                            <div class="tab-pane" id="h{{$count2}}">
                                        @endif
                                            <ul class="list-unstyled">
                                                @foreach ($hist2 as $item)
                                                    <li>{{date("d M Y",strtotime($item))}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <?php $count2++;?>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            We have no record of this song being played before
                        @endif
                    </div>
                </div>
             </div>
            <div v-if="videosource" class="tab-pane" id="k4">
                <iframe id="ytplayer" type="text/html" width="640" height="390" :src="formdata.video"
                  frameborder="0"/>
                </iframe>
            </div>
            <div class="tab-pane" id="k5">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">{{$song->title}} <span class="small">OpenLP slide</span></h3>
                    </div>
                    <div class="box-body">
                        {!!nl2br($openlp)!!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop

@section('js')
@include('base::worship.partials.scripts')

<script type="text/javascript">
var vm1 = new Vue({
  el: '#tabs',
  data: {
      formdata: {
      },
      brlyrics: '',
      pdfsource:'',
      videosource: '',
      history:''
  },
  created: function() {
      this.getMe();
      @if (isset($history))
        this.history='{{json_encode($history)}}';
      @endif
      this.loadVideo();
  },
  methods: {
      getMe: function() {
          $.ajax( { url: "{{url('/')}}/admin/worship/songapi/" + {{$song->id}},
                success: 
                  function(dat) {
                    this.formdata = dat.song;
                    this.brlyrics = dat.brlyrics.replace(/(\r\n|\n\r|\r|\n)/g, '<br>');
                  }.bind(this)
              });  
      },
      updateMe: function() {
          this.formdata.audio=this.formdata.audio.replace("https://", "");
          this.formdata.audio=this.formdata.audio.replace("http://", "");
          this.formdata.video=this.formdata.video.replace("https://", "");
          this.formdata.video=this.formdata.video.replace("http://", "");
          this.formdata.music=this.formdata.music.replace("https://", "");
          this.formdata.music=this.formdata.music.replace("http://", "");
          this.$http.put('{{url('/')}}/admin/worship/songs/' + {{$song->id}},this.formdata);
          alert('Data has been updated');
          this.videosource=this.formdata.video;
          this.pdfsource='';
      },
      transposeUp: function() {
          this.formdata.transpose='up';
          this.$http.put('{{url('/')}}/admin/worship/songs/' + {{$song->id}},this.formdata).then(function (response){
              this.formdata.lyrics=response.data.lyrics;
              this.formdata.key=response.data.key;
          });
          this.pdfsource='';
      },
      transposeDown: function() {
          this.formdata.transpose='down';
          this.$http.put('{{url('/')}}/admin/worship/songs/' + {{$song->id}},this.formdata).then(function (response){
              this.formdata.lyrics=response.data.lyrics;
              this.formdata.key=response.data.key;
          });
          this.pdfsource='';
      },
      loadPdf: function() {
          this.pdfsource='{{url('/')}}/admin/worship/songs/' + {{$song->id}} + '/pdf';
      },
      loadVideo:function() {
          this.videosource=this.formdata.video;
      }
  }
});
</script>
@stop
