@extends('connexion::templates.backend')

@section('css')
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Edit user','Users',route('admin.users.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.users.update',$user->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class="col-md-6">
                      @include('connexion::users.partials.edit-fields')
                    </div>
                    <div class="col-md-6">
                      <h4>Recent system activity</h4>
                      <ul class="list-unstyled">
                      @foreach ($user->activity->sortByDesc('created_at')->take(20) as $activity)
                        <li>{{$activity->created_at}} [{{$activity->description}}]</li>
                      @endforeach
                      </ul>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.users.show',$user->id)) }}
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="{{$user->name}}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.users.destroy', [$user->id]) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.delete-modal')
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.input-individual').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
        $('.input-role').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
          maxOptions: 30,
        });
    });
    @include('connexion::shared.delete-modal-script')
</script>
@stop