@extends('connexion::worship.page')

@section('content')
<h1>Guitar chords</h1>
<div class="row">
    <div class="col-sm-3">
        @if (@getimagesize($fullname))
            <img src="{{$fullname}}">
        @elseif (isset($fullname))
            <h3>{{str_replace('_','/',$chord)}}</h3>
            This chord does not exist on the system - please add it now
        @endif
        {!! Form::open(array('route' => array('chords',$chord), 'method'=>'get', 'class' => 'form-horizontal', 'role' => 'form')) !!}
        {!! Form::label('chord','Chord name (eg: A)', array('class'=>'control-label')) !!}
        {!! Form::text('chord', str_replace('_','/',$chord), array('class' => 'form-control')) !!}
        {!! Form::label('strings','String (eg: x02220)', array('class'=>'control-label')) !!}
        {!! Form::text('strings', null, array('class' => 'form-control')) !!}
        {!! Form::label('barre','Barre (eg: 216 - 2nd fret, strings 1 to 6) or blank', array('class'=>'control-label')) !!}
        {!! Form::text('barre', null, array('class' => 'form-control')) !!}<br>
        @if ($chord)
            {!! Form::submit('Update chord', array('class'=>'btn btn-default')) !!} 
        @else
            {!! Form::submit('Add chord', array('class'=>'btn btn-default')) !!}
        @endif
        <a href="{{url('/')}}/chords" class="btn btn-default">Cancel</a>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-9">
        <div class="nav-tabs-custom">
            <ul id="myTab" class="nav nav-tabs">
                <li class="active">
                    <a href="#k0" data-toggle="tab">A</a>
                </li>
                <li>
                    <a href="#k1" data-toggle="tab">A# / Bb</a>
                </li>
                <li>
                    <a href="#k2" data-toggle="tab">B</a>
                </li>
                <li>
                    <a href="#k3" data-toggle="tab">C</a>
                </li>
                <li>
                    <a href="#k4" data-toggle="tab">C# / Db</a>
                </li>
                <li>
                    <a href="#k5" data-toggle="tab">D</a>
                </li>
                <li>
                    <a href="#k6" data-toggle="tab">D# / Eb</a>
                </li>
                <li>
                    <a href="#k7" data-toggle="tab">E</a>
                </li>
                <li>
                    <a href="#k8" data-toggle="tab">F</a>
                </li>
                <li>
                    <a href="#k9" data-toggle="tab">F# / Gb</a>
                </li>
                <li>
                    <a href="#k10" data-toggle="tab">G</a>
                </li>
                <li>
                    <a href="#k11" data-toggle="tab">G# / Ab</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active" id="k0">
                    @if (array_key_exists("A",$chords))
                        @foreach ($chords['A'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k1">
                    @if (array_key_exists("A#",$chords))
                        @foreach ($chords['A#'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @endif
                    @if (array_key_exists("Bb",$chords))
                        @foreach ($chords['Bb'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @elseif (!array_key_exists("A#",$chords))
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k2">
                    @if (array_key_exists("B",$chords))
                        @foreach ($chords['B'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k3">
                    @if (array_key_exists("C",$chords))
                        @foreach ($chords['C'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k4">
                    @if (array_key_exists("C#",$chords))
                        @foreach ($chords['C#'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @endif
                    @if (array_key_exists("Db",$chords))
                        @foreach ($chords['Db'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @elseif (!array_key_exists("C#",$chords))
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k5">
                    @if (array_key_exists("D",$chords))
                        @foreach ($chords['D'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k6">
                    @if (array_key_exists("D#",$chords))
                        @foreach ($chords['D#'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @endif
                    @if (array_key_exists("Eb",$chords))
                        @foreach ($chords['Eb'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @elseif (!array_key_exists("D#",$chords))
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k7">
                    @if (array_key_exists("E",$chords))
                        @foreach ($chords['E'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k8">
                    @if (array_key_exists("F",$chords))
                        @foreach ($chords['F'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k9">
                    @if (array_key_exists("F#",$chords))
                        @foreach ($chords['F#'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @endif
                    @if (array_key_exists("Gb",$chords))
                        @foreach ($chords['Gb'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @elseif (!array_key_exists("F#",$chords))
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k10">
                    @if (array_key_exists("G",$chords))
                        @foreach ($chords['G'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @else
                        No chords in this key
                    @endif
                </div>
                <div class="tab-pane" id="k11">
                    @if (array_key_exists("G#",$chords))
                        @foreach ($chords['G#'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @endif
                    @if (array_key_exists("Ab",$chords))
                        @foreach ($chords['Ab'] as $tc)
                            <img width="60" src="{{url('/') . '/public/images/chords/' . $tc }}">
                        @endforeach
                    @elseif (!array_key_exists("G#",$chords))
                        No chords in this key
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    @include('connexion::worship.partials.scripts')
@stop