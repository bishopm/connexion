@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/fullcalendar/fullcalendar.print.css') }}" rel="stylesheet" type="text/css" media="print"/>
    <link href="{{ asset('/vendor/bishopm/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Logged in as: 
                      @if (isset($currentUser->individual))
                          <b>{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</b>
                      @else
                          <b>{{$currentUser->name}}</b>
                      @endif
                    </div>
                    <div class="panel-body">
                        <div id="calendar" class="col-md-9">
                        </div>
                        <div class="col-md-3">
                        <h2>To do</h2>
                        @foreach ($actions as $action)
                            <li>{{$action->description}}</li>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
  $(document).ready(function() {
      $('#calendar').fullCalendar({
          googleCalendarApiKey: 'AIzaSyD4y1RyWYcv2nqBlp0wJZr6ULGWGt8VrX4',
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          views: {
              week: { columnFormat: 'ddd D/M' },
              day: { columnFormat: 'ddd' },
              month: { columnFormat: 'ddd' }
          },
          events: {!! json_encode($pcals) !!},
          eventSources:  {!! json_encode($cals) !!},
          defaultView: 'agendaWeek'
      });
  });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.5/moment.js"></script>
  <script src="{{ asset('/vendor/bishopm/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/vendor/bishopm/fullcalendar/gcal.js') }}" type="text/javascript"></script>
@endsection
