<div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('servicedate','Service date (defaults to next Sunday)', array('class'=>'control-label')) !!}
            <input type="text" id="servicedate" name="servicedate" value="{{$sunday}}" class="form-control">
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.5/moment.min.js"></script>
    <script src="{{ asset('/public/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(function () {
        $(".select2").select2();
        $('#servicedate').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            format: 'YYYY-MM-DD'
        });
    });
    </script>
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('service_id','Congregation', array('class'=>'control-label')) !!}
            <select class="form-control" name="service_id">
                @foreach ($services as $service)
                    <option value="{{$service->id}}">{{$service->service}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
