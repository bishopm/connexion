<div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('servicedate','Service date (defaults to next Sunday)', array('class'=>'control-label')) !!}
            <input type="text" id="servicedate" name="servicedate" value="{{$sunday}}" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('service_id','Congregation', array('class'=>'control-label')) !!}
                <select name="service_id" class="selectize">
                    @foreach ($services as $service)
                        <option value="{{$service->id}}">{{$society}} {{$service->servicetime}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
