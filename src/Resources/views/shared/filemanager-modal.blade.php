<div class="modal fade" id="modal-filemanager" tabindex="-1" role="dialog" aria-labelledby="fmgr-confirmation-title" aria-hidden="true">
    <div class="modal-dialog" style="width:100%;height=100%;">
        <div class="modal-content" style="min-height:100%;height=100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <form id="upload_form" enctype="multipart/form-data" method="post" action="{{route('admin.addimage')}}">
                    <h3 class="modal-title" id="fmgr-confirmation-title">Choose a file <small>Folder: {{$folder}}</small>
                    <label id="openbut" class="btn btn-primary" for="upload">
                        <input id="upload" type="file" style="display:none;">
                        Open file
                    </label>
                    <a href="#" class="btn btn-primary" style="display:none;" id="upload-result">OK</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal" style="display:none;" id="cancelbut">Cancel</a></h3>
                    </h3>
                    <input type="hidden" name="folder" value="{{$folder}}">
                    <input type="hidden" id="filename" name="filename">
                </form>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <div class="row">
                    <div class="col-xs-12">
                        Choose from an existing image in this folder or upload an image and crop if resize as necessary
                    </div>
                <?php
                    $fff=public_path() . '/storage/' . $folder;
                    if (!file_exists($fff)){
                        mkdir($fff, 0755, true);
                    }
                ?>
                    <div class="col-xs-8">
                        @foreach (scandir($fff) as $thisfile)
                            @if (substr($thisfile,0,1)<>'.')
                                <div class="col-xs-2"><a class="fmgr" href="#{{$thisfile}}">{{$thisfile}}</a></div>
                                <div class="col-xs-4"><img style="padding-bottom:10px;" height="40px" src="{{url('/')}}/storage/{{$folder}}/{{$thisfile}}"></div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-xs-4">
                        <div id="upload-demo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>