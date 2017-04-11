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
});