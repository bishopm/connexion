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
                $('#modal-filemanager').modal('hide');
            }
        });                            
    });
});