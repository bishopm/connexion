@if ($sermon) 
    @if ($sermon->series->image) series->slug)}}\">series->image}}\"> @endif Audio Player
Download File
{{date(\"j M\", strtotime($sermon->servicedate))}}: series->slug,$sermon->slug))}}\">{{$sermon->title}}
@if ($sermon->individual) individual->slug}}\">{{$sermon->individual->firstname}} {{$sermon->individual->surname}} @else Guest preacher @endif
Browse full sermon library
@else
No sermons have been added yet
@endif