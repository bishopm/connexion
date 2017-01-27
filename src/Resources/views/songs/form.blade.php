<div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('title','Title', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.title" name="title" class="form-control">
            @else
                <input type="text" name="title" class="form-control">
            @endif
        </div>
        <div class="col-sm-6">
            {!! Form::label('author','Author', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.author" name="author" class="form-control">
            @else
                <input type="text" name="author" class="form-control">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('copyright','Copyright', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.copyright" name="copyright" class="form-control">
            @else
                <input type="text" name="copyright" class="form-control">
            @endif
        </div>
        <div class="col-sm-2">
            {!! Form::label('key','Key', array('class'=>'control-label')) !!}
            <select name="key" v-model="formdata.key" class="form-control">
                @foreach ($keys as $key)
                    @if ((!$is_new) and ($song->key==$key))
                        <option selected>{{$key}}</option>
                    @else
                        <option>{{$key}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            {!! Form::label('tempo','Time signature', array('class'=>'control-label')) !!}
            <select name="tempo" v-model="formdata.tempo" class="form-control">
                @foreach ($tempos as $tempo)
                    @if ((!$is_new) and ($song->tempo==$tempo))
                        <option selected>{{$tempo}}</option>
                    @else
                        <option>{{$tempo}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            {!! Form::label('tempo','Music type', array('class'=>'control-label')) !!}
            <select name="musictype" v-model="formdata.musictype" class="form-control">
                @if ((!$is_new) and ($song->musictype=="hymn"))
                    <option selected>hymn</option>
                    <option>contemporary</option>
                @else
                    <option>hymn</option>
                    <option selected>contemporary</option>
                @endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('audio','Audio', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.audio" name="audio" class="form-control">
            @else
                <input type="text" id="audio" name="audio" onchange="neaten(event);" class="form-control">
            @endif
        </div>
        <div class="col-sm-6">
            {!! Form::label('video','Video', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.video" name="video" class="form-control">
            @else
                <input type="text" id="video" name="video" onchange="neaten(event);" class="form-control">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('music','Sheet music', array('class'=>'control-label')) !!}
            @if (!$is_new)
                <input type="text" v-model="formdata.music" name="music" class="form-control">
            @else
                <input type="text" onchange="neaten(event);" name="music" class="form-control">
            @endif
        </div>
        <div class="col-sm-6">
            <label for="tags">Tags</label>
            <select name="tags[]" id="tagselect" class="input-tags" multiple>
                @foreach ($tags as $tag)
                    @if ((isset($stags)) and (in_array($tag->name,$stags)))
                        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
                    @else
                        <option value="{{$tag->name}}">{{$tag->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    @if ($is_new)
        <script language="javascript">
            function neaten(event){
                if(event.target){
                    //firefox, safari
                    myObj = document.getElementById(event.target.id);
                    myObj.value=myObj.value.replace(/^https?:\/\//, '');
                } else {
                    //IE
                    myObj = document.getElementById(event.srcElement.id);
                    myObj.value=myObj.value.replace(/^https?:\/\//, '');
                }
            }
        </script>
    @endif
    {!! Form::label('lyrics','Lyrics', array('class'=>'control-label')) !!}
    @if (!$is_new)
    <textarea class="form-control" rows="20" name="lyrics" cols="50" id="lyrics" v-model="formdata.lyrics"></textarea>
    @else
    <textarea class="form-control" rows="20" name="lyrics" cols="50" id="lyrics"></textarea>
    @endif
</div>
