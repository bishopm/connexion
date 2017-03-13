$( document ).ready(function() {
    $('#modal-login').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actionTarget = button.data('action-target');
        var modal = $(this);
        modal.find('form').attr('action', actionTarget);
    });
});