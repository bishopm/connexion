function setupImage(img) {
    alert(img);
    $('#filediv').html("<div id='filediv'><a class='btn btn-primary' data-toggle='modal' data-target='#modal-filemanager'>Browse server or upload new file</a></div>");
    if (img){
        $('#thumbdiv').html("<a data-toggle='modal' data-target='#modal-filemanager'><img width='300px' class='img-thumbnail' src='" + img + "'></a>");
    }
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
    }
});
$( document ).ready(function() {
    $('#modal-filemanager').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actionTarget = button.data('action-target');
        var modal = $(this);
        modal.find('form').attr('action', actionTarget);
        $('.fmgr').on('click',function(e){
        	$('#image').val(e.target.innerHTML);
            setupImage("{{url('/')}}" + "/storage/{{$folder}}/" + e.target.innerHTML);
        	$('#modal-filemanager').modal('hide');
        });
    });
    $("#upload_form").on("submit", function(event){
        event.preventDefault();                     
        var form_url = $("form[id='upload_form']").attr("action");
        $.ajax({
            url:  form_url,
            type: 'POST',
            data: new FormData(this),
            contentType: false, 
            processData: false,
            success: function (result) {
                $('#image').val(result);
                setupImage("{{url('/')}}" + "/storage/{{$folder}}/" + result);
                $('#modal-filemanager').modal('hide');
            }
        });                            
    });
    setupImage('{{$media}}');
});