<div class="modal fade modal-primary" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Settings</h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Circuit</label>
                            <select class="form-control" name="circuit">
                                @foreach ($circuits as $circuit)
                                    <option value="{{$circuit->id}}">{{$circuit->circuitnumber}} {{$circuit->circuit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-flat">Save</button> <a class="btn btn-default btn-flat" href="{{url('/')}}"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>