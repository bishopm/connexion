<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li class="visible-xs"><a href="{{url('/')}}"><i class='fa fa-home'></i> Home </a></li>
            <li class="visible-xs"><a href="{{url('/')}}/admin/worship/chords"><i class='fa fa-music'></i> Guitar Chords </a></li>
            <li class="visible-xs"><a href="{{url('/')}}/admin/worship/songs/create"><i class='fa fa-plus-square'></i> Add a new song </a></li>
            <li class="visible-xs"><a href="{{url('/')}}/admin/worship/sets"><i class='fa fa-list-ol'></i> Worship sets </a></li>
            {!! Form::open(array('url' => 'search','id' => 'searchform', 'method'=>'get','v-on:submit.prevent','class' => 'sidebar-form', 'role' => 'form')) !!}
            <div class="input-group">
                <input v-model="q" v-on:keyup="searchMe" autocomplete=off autofocus="autofocus" type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
            {!! Form::close() !!}
            <li class="songtitles" v-for="song in songs">
                <a class="@{{song.musictype}}" href="{{url('/')}}/admin/worship/songs/@{{song.id}}">@{{ song.title }}</a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<script src="{{ asset('vendor/bishopm/vuejs/vue.js') }}"></script>
<script src="{{ asset('vendor/bishopm/vuejs/vue-resource.js') }}"></script>
<script>
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
new Vue({
  el: '#sidebar',
  data: {
      q: '',
      songs: []
  },
  methods: {
      searchMe: function() {
          if (this.q.length>1){
              this.$http.get('{{url('/')}}/admin/worship/search/' + this.q,function(dat) {
                  this.songs = dat;
              }.bind(this));
          }
      }
  }
});
</script>
