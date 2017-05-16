$( document ).ready(function() {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
	    }
    });
    $('#modal-login').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actionTarget = button.data('action-target');
        var modal = $(this);
        modal.find('form').attr('action', actionTarget);
    });
    $('#emailbox').on('keyup', function (e) {
		$.ajax({
	        type : 'GET',
	        url : '{{url('/')}}' + '/admin/getusername/' + $('#emailbox').val(),
	        success: function(e){
	        	if (e!=='error'){
	        		var usernamebox = $("#usernamebox");
                    usernamebox.empty();
	        		var names = $.parseJSON(e);
                    for (var i = 0; i < names.length; i++) {
                        usernamebox.append($('<option>', {
                            value: names[i],
                            text:names[i],
                        }));
                    }
                    usernamebox.change();
	        	}
	        }
    	});
    });
    $('#usernamebox').change(function (){
        $("#name").val(this.value);
    });
});
function usernametell() {
	$('#emaildiv').show();
	$('#emailbox').focus();
}