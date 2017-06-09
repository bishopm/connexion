$( document ).ready(function() {
    $("#submitbutton").on("click", function(event){
        if (($('#name').val()=='') || ($('#email').val()=='') || ($('#message').val()=='')){
            $('#errormsg').css("display","block");
            $('#errormsg').text('Please include your name, email address and the order message.');
        } else {
            $("#orderbookform").submit();
        }
    });
});