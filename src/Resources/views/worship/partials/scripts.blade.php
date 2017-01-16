<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.8/vue.js"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
    }
  });
  var vm2 = new Vue({
    el: '#sidebar',
    data: {
        q: '',
        songs: []
    },
    methods: {
        searchMe: function() {
          if (this.q.length>1){
            $.ajax(
              { url: "{{url('/')}}/admin/worship/search/" + this.q,
                success: 
                  function(dat) {
                    this.songs = dat;
                  }.bind(this)
              });
          }
        }
    }
  });
</script>
