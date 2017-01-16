@extends('base::worship.page')

@section('content')
<h3 class="box-title">Guitar chords
    @if (Helpers::perm('edit'))
        <a href="chords/create" class="btn btn-default">Add a new chord</a>
    @endif
</h3>
<div class="row">
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
            @if (isset($chords))
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active" id="k0">
                        @if (array_key_exists("A",$chords))
                            @foreach ($chords['A'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k1">
                        @if (array_key_exists("A#",$chords))
                            @foreach ($chords['A#'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @endif
                        @if (array_key_exists("Bb",$chords))
                            @foreach ($chords['Bb'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @elseif (!array_key_exists("A#",$chords))
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k2">
                        @if (array_key_exists("B",$chords))
                            @foreach ($chords['B'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k3">
                        @if (array_key_exists("C",$chords))
                            @foreach ($chords['C'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k4">
                        @if (array_key_exists("C#",$chords))
                            @foreach ($chords['C#'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @endif
                        @if (array_key_exists("Db",$chords))
                            @foreach ($chords['Db'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @elseif (!array_key_exists("C#",$chords))
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k5">
                        @if (array_key_exists("D",$chords))
                            @foreach ($chords['D'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k6">
                        @if (array_key_exists("D#",$chords))
                            @foreach ($chords['D#'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @endif
                        @if (array_key_exists("Eb",$chords))
                            @foreach ($chords['Eb'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @elseif (!array_key_exists("D#",$chords))
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k7">
                        @if (array_key_exists("E",$chords))
                            @foreach ($chords['E'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k8">
                        @if (array_key_exists("F",$chords))
                            @foreach ($chords['F'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k9">
                        @if (array_key_exists("F#",$chords))
                            @foreach ($chords['F#'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @endif
                        @if (array_key_exists("Gb",$chords))
                            @foreach ($chords['Gb'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @elseif (!array_key_exists("F#",$chords))
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k10">
                        @if (array_key_exists("G",$chords))
                            @foreach ($chords['G'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @else
                            No chords in this key
                        @endif
                    </div>
                    <div class="tab-pane" id="k11">
                        @if (array_key_exists("G#",$chords))
                            @foreach ($chords['G#'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @endif
                        @if (array_key_exists("Ab",$chords))
                            @foreach ($chords['Ab'] as $nn)
                                <a href="{{url('/')}}/chords/{{$nn}}/edit"><img width="60" src="{{url('/') . '/public/images/chords/' . $nn }}.png"></a>
                            @endforeach
                        @elseif (!array_key_exists("G#",$chords))
                            No chords in this key
                        @endif
                    </div>
                </div>
            @else
                <br>No chords have been added yet<br><br>
            @endif
        </div>
    </div>
</div>
@stop
