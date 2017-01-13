@extends('app')

@section('content')
<div id="setpage" class="box box-default">
    <div class="box-header">
        @include('shared.messageform')
        <h3 class="box-title">@{{set.servicedate}} <span class="small">@{{service}}</span></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <select class="form-control select2" v-model="newitem">
                        <option>Choose a new song</option>
                        <option v-for="newsong in newsongs" value="@{{newsong.id}}">@{{newsong.title}}</option>
                    </select>
                </div>
                <div class="col-sm-12">&nbsp;</div>
                <div class="col-sm-12">
                    <script type="text/javascript">
                    $(".select2").select2();
                    $('.select2').on('change',function(){
                        vm['addsong'] = $(this).val();
                    });
                    </script>
                    <ul class="list-group" v-sortable="{ onUpdate: onUpdate }">
                        <li v-for="item in items" class="list-group-item">@{{ item.title }}<a href="#" v-on:click="deleteMe(item)"><span class="pull-right fa fa-times"></span></a></li>
                        <p v-show="items.length==0">No items have been added to this set yet</p>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <form method="POST" action="{{url('/')}}/sets/sendemail">
                        {{ csrf_field() }}
                        <div class="col-sm-12">
                            <textarea name="message" class="form-control" rows="20">@{{message}}</textarea>
                        </div>
                        <div class="col-sm-12">&nbsp;</div>
                        <div class="col-sm-12">
                            <button href="#" class="btn btn-default" type="submit">Send email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../public/js/vue.js"></script>
<script src="../public/js/vue-resource.js"></script>
<script src="../public/js/Sortable.js"></script>
<script src="../public/js/vue-sortable.js"></script>
<script>
Sortable.create(setpage, {
    group: "sorting",
    sort: true
});
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
var vm = new Vue({
    el: '#setpage',
    created: function() {
        this.getMe();
    },
data: {
    items: [],
    newsongs: [],
    set: [],
    service: [],
    addsong: 0,
    message:'',
    newitem: ''
},
watch: {
    addsong: function(e){
        var storesong = {set_id:this.set.id, song_id:e, itemorder:this.items.length};
        this.$http.post('{{env('WORSHIP_FOLDER')}}/setitems',JSON.stringify(storesong));
        this.getMe();
    },

    items: {
      handler: function (val, oldVal) {
          msg='Hi Janet\n\nThe songs for the ' + this.service + ' service for ' + this.set.servicedate + ' are:\n\n';
          for (i in this.items){
              msg = msg + this.items[i].title +'\n';
          }
          msg = msg + '\nThank you!\n\n' + '{{explode(' ',auth()->user()->name)[0]}}';
          this.message=msg;
        }
    }
},
methods: {
    getMe: function() {
        this.$http.get('{{env('WORSHIP_FOLDER')}}/setsapi/' + {{$set->id}}).then(function(dat) {
            this.items = dat.data.songs;
            this.newsongs = dat.data.newsongs;
            this.set=dat.data.set;
            this.service=dat.data.service;
        });
    },
    deleteMe: function(d) {
        this.$http.delete('{{env('WORSHIP_FOLDER')}}/setitems/'+d.id).then(function(dat) {
            this.getMe();
        });
    },
    onUpdate(event) {
        this.items.splice(event.newIndex, 0, this.items.splice(event.oldIndex, 1)[0]);
        this.$http.put('{{env('WORSHIP_FOLDER')}}/setsapi/' + this.set.id,JSON.stringify(this.items));
    }
}
});
</script>
@stop
