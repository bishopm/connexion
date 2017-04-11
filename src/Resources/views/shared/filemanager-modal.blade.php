<div class="modal fade" id="modal-filemanager" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Choose a file <small>Folder: {{$folder}}</small></h3>
                <form enctype="multipart/form-data" method="post" action="{{$action}}" files="true">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-6"><input type="file" name="file" required=""/></div><div class="col-md-6"><button id="submitbutton" type="submit">Upload</button></div>
                </form>
            </div>
            <div class="modal-body">
                <div class="row">
                @foreach (scandir(public_path() . '/storage/' . $folder) as $thisfile)
                    @if (substr($thisfile,0,1)<>'.')
                        <div class="col-xs-2"><a class="fmgr" href="#{{$thisfile}}">{{$thisfile}}</a></div>
                        <div class="col-xs-4"><img style="padding-bottom:10px;" height="40px" src="{{url('/')}}/storage/{{$folder}}/{{$thisfile}}"></div>
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>