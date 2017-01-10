$( document ).ready(function() {
    $('#modal-delete-confirmation').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actionTarget = button.data('action-target');
        var actionEntity = button.data('action-entity');
        var modal = $(this);
        modal.find('form').attr('action', actionTarget);
		$('.modal-title').html('Delete ' + actionEntity);
    });
});