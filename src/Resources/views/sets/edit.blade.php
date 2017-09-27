@extends('connexion::templates.backend')

@section('content')
    {{ Form::pgHeader('Edit set','Sets',route('admin.sets.index')) }}
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.sets.update',$set->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::sets.partials.edit-fields')
                    <div class="form-group">
                        <label for="service_id" class="control-label">Service</label>
                        <select name="service_id" class="selectize">
                          @foreach ($services as $service)
                            @if ($service->id==$set->service_id)
                                <option selected value="{{$service->id}}">{{$service->servicetime}})</option>
                            @else
                                <option value="{{$service->id}}">{{$service->servicetime}})</option>
                            @endif
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.sets.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop