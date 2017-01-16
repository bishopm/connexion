@extends('base::worship.page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div id="setpage" class="box box-default">
    <div class="box-header">
        @include('base::shared.errors')
        <h3 class="box-title">@{{set.servicedate}} <span class="small">@{{service}}</span></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <select>
                        <option v-for="newsong in newsongs" v-bind:value="newsong.id">
                            @{{ newsong.title }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-12">&nbsp;</div>
                <div class="col-sm-12">
                    <ul class="list-group">
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
@stop
@section('js')
    @include('base::worship.partials.scripts')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/jquery.nestable.js') }}"></script>  
    <script>
    var vm1 = new Vue({
        el: '#setpage',
        created: function() {
            this.getMe();
        },
        ready: $( document ).ready(function() {
                $('.selectize').selectize({ 
                  maxOptions: 30
                });
            }),
        data: {
            items: [],
            newsongs: [],
            set: [],
            service: [],
            addsong: 0,
            message:''
        },
        watch: {
            addsong: function(e){
                var storesong = {set_id:this.set.id, song_id:e, itemorder:this.items.length};
                this.$http.post('{{url('/')}}/admin/worship/setitems',JSON.stringify(storesong));
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
                $.ajax(
                    { url: "{{url('/')}}/admin/worship/setsapi/{{$set->id}}",
                    success: 
                        function(dat) {
                            this.items = dat.songs;
                            this.newsongs = dat.newsongs;
                            this.set=dat.set;
                            this.service=dat.service;
                        }.bind(this)
                    }
                  );
            },
            deleteMe: function(d) {
                this.$http.delete('{{url('/')}}/admin/worship/setitems/'+d.id).then(function(dat) {
                    this.getMe();
                });
            },
            onUpdate(event) {
                this.items.splice(event.newIndex, 0, this.items.splice(event.oldIndex, 1)[0]);
                this.$http.put('{{url('/')}}/admin/worship/setsapi/' + this.set.id,JSON.stringify(this.items));
            }
        }
    });
    </script>
@stop
