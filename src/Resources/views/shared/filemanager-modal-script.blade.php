function setupImage(img) {
    $('#filediv').html("<div id='filediv'><a id='loadbut' class='btn btn-primary' data-toggle='modal' data-target='#modal-filemanager'>Choose image</a> <span id='cropbut' onclick='docrop({{$width}},{{$height}});' class='btn btn-default'>Crop or resize</span> <span style='display:none;' onclick='savecroppie();' id='savebut' class='btn btn-default'>Save changes</span> <span style='display:none;' onclick='destroycroppie();' id='cancelbut' class='btn btn-default'>Cancel</span></div>");
    if (img){
        pic="<img id='thumbpic' width='300px' class='img-thumbnail' src='" + img + "'>";
        $('#thumbdiv').html(pic);
    }
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
    }
});
function docrop(ww,hh){
    cropp=$('#thumbpic').croppie({
        viewport: {
            width: ww,
            height: hh,
            type: 'square'
        },
        boundary: {
            width: ww+50,
            height: hh+50
        }
    });
    $('#savebut').show();
    $('#cancelbut').show();
    $('#cropbut').hide();
    $('#loadbut').hide();
};
function destroycroppie(){
    cropp.croppie('destroy');
    $('#cropbut').show();
    $('#loadbut').show();
    $('#savebut').hide();
    $('#cancelbut').hide();
};
function savecroppie(){
    cropp.croppie('result', 'base64').then(function(base64) {
        $.ajax({ 
            type: "POST", 
            url: "{{url('/')}}/admin/updateimage/{{$folder}}{{$entity or ''}}",
            dataType: 'text',
            data: {
                base64data : base64
            },
            success: function (fname) {
                destroycroppie();
                $("#thumbpic").attr('src', fname + '?timestamp=' + new Date().getTime());              
            }
        });    
    });
};
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
    if ($('#image').val()==''){
        setupImage($('#image').val());
    } else {
        setupImage("{{url('/')}}" + "/storage/{{$folder}}/" + $('#image').val());
    }
});