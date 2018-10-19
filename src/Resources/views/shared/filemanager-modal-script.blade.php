function setupImage(img) {
    $('#filediv').html("<div id='filediv'><a id='loadbut' class='btn btn-primary' data-toggle='modal' data-target='#modal-filemanager'>Choose image</a></div>");
    if (img){
        pic="<img id='thumbpic' width='300px' class='img-thumbnail' src='" + img + "'>";
        $('#thumbdiv').html(pic);
    }
}

$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    var $uploadCrop;

    function readFile(input) {
        if (input.files && input.files[0]) {
            $('#filename').val(input.files[0]['name']);
            $uploadCrop = $('#upload-demo').croppie({
                viewport: {
                    width: {{$width}},
                    height: {{$height}},
                    type: 'square'
                },
                boundary: {
                    width: {{$width+100}},
                    height: {{$height+100}}
                }
            });
            var reader = new FileReader();          
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                });
                $('.upload-demo').addClass('ready');
            }           
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#upload').on('change', function () { readFile(this); });
    $('#upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', 'base64').then(function(base64) {
            $.ajax({ 
                type: "POST", 
                url: "{{url('/')}}/admin/updateimage/{{$folder}}{{$entity ?? ''}}",
                dataType: 'text',
                data: {
                    base64data : base64,
                    filename: $('#filename').val()
                },
                success: function (fname) {
                    fileonly=fname.split('/').pop();
                    setupImage(fname + '?timestamp=' + new Date().getTime());
                    $('#image').val(fileonly);
                    $('#modal-filemanager').modal('hide');              
                },
                error : function(error) {
                    console.log(error);
                }
            });    
        });
    });
    $('#openbut').on('click', function (ev) {
        $('#upload-result').show();
        $('#openbut').hide();
        $('#cancelbut').show();
    });
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
    if ($('#image').val()==''){
        setupImage($('#image').val());
    } else {
        setupImage("{{url('/')}}" + "/storage/{{$folder}}/" + $('#image').val());
    }
});