<div class="row">
    <div class="col-sm-6">
        {!! Form::label('chordname','Chord name (eg: A)', array('class'=>'control-label')) !!}
        @if ($is_new)
            {!! Form::text('chordname', str_replace('_','/',str_replace('^','#',$chordname)), array('class' => 'form-control')) !!}
        @else
            {!! Form::text('chordname', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
        @endif
        {!! Form::label('fingering','String (eg: x02220)', array('class'=>'control-label')) !!}
        {!! Form::text('fingering', null, array('class' => 'form-control')) !!}
        {!! Form::label('barre','Barre (eg: 216 - 2nd fret, strings 1 to 6) or blank', array('class'=>'control-label')) !!}
        {!! Form::text('barre', null, array('class' => 'form-control')) !!}<br>
    </div>
    <div class="col-sm-6">
        @if (!$is_new)
            <img src="{{url('/')}}/public/images/chords/{{$chord->id}}.png">
        @endif
    </div>
</div>
