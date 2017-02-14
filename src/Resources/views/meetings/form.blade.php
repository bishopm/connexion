<div class="box-body">
    {!! Form::label('description','Meeting description', array('class'=>'control-label')) !!}
    {!! Form::text('description', null, array('class' => 'form-control')) !!}
    {!! Form::label('venue','Venue', array('class'=>'control-label')) !!}
    <select name="society_id" class="form-control select2">
        <option></option>
        @foreach ($societies as $society)
          	@if ((!$is_new) and ($meeting->society_id==$society->id))
          		<option selected value="{{$society->id}}">{{$society->society}}</option>
          	@else
          		<option value="{{$society->id}}">{{$society->society}}</option>
            @endif
        @endforeach
    </select>
    {!! Form::label('meetingdatetime','Time and date', array('class'=>'control-label')) !!}
    @if (!$is_new)
        <input type="text" value="{{$meetingdatetime}}" name="meetingdatetime" id="meetingdatetime" class="form-control">
    @else
        <input type="text" name="meetingdatetime" id="meetingdatetime" class="form-control">
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.5/moment.min.js"></script>
    <script src="{{ asset('/public/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(function () {
        $('#meetingdatetime').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            showDropdowns: true,
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $(".select2").select2();
    });
    </script>
</div>
