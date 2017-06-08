$( document ).ready(function() {
    $("#submitbutton").on("click", function(event){
        alert('ppp');
        if (($("#name").val()<>'') and ($("#email").val()<>'') and ($("#message").val()<>'')){
            console.log('all ok');
            $("#orderbookform").submit();
        } else {
            console.log('all NOT ok');
            alert('Please include your name, email address and the order message.');
        }
    });
});