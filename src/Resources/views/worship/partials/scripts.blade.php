<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.8/vue.js"></script>
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
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
          tagselect=$("#songsearch")[0];
          if (this.q.length>1 || tagselect.selectize.caretPos>0){
            $.ajax({ 
                type: 'POST',
                url: "{{url('/')}}/admin/worship/search",
                data: $('#searchform').serialize(),
                success: 
                  function(dat) {
                    this.songs = dat;
                  }.bind(this)
              });
          } else {
            this.songs=[];
          }

        }
    }
  });
  $('#songsearch').on('change', function() {
      vm2.searchMe();
  });
</script>