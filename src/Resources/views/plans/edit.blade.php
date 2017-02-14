@extends('app')

@section('content')
@include('shared.messageform')

{!! Form::open() !!}
<div class="container-fluid">
<table class="table table-condensed table-striped table-responsive table-hover">
  <thead>
    <tr class="active">
      <th colspan="2" class="text-right">
          <span class="btn-toolbar">
              <span class="btn-group-xs">
                  <a href="{{url('/')}}/{{$prev}}/edit" title="Previous quarter" class="btn btn-danger btn-sm"><span class="fa fa-angle-double-left"></span></a>&nbsp;
                  <a href="{{url('/')}}/{{$next}}/edit" title="Next quarter" class="btn btn-danger btn-sm"><span class="fa fa-angle-double-right"></span></a>&nbsp;
              </span>
              <span class="btn-group-xs">
                  <button title="Save plan data" class="btn btn-sm btn-danger" type="submit"><span class="fa fa-save"></span></button>
                  <a href="view" title="View a PDF version of the plan" class="btn btn-sm btn-danger"><span class="fa fa-file-pdf-o"></span></a>
              </span>
          </span>
      </th>
      @foreach ($sundays as $s1)
        <th class="text-center">{{date("j M",$s1['dt'])}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
  <?php $count=1; ?>
  @foreach ($societies as $soc)
    @if ($count%5 == 0)
        <tr class="active">
          <th colspan="2" class="text-right">
              <span class="btn-toolbar">
                  <span class="btn-group-xs">
                      <a href="{{url('/')}}/{{$prev}}/edit" title="Previous quarter" class="btn btn-danger btn-sm"><span class="fa fa-angle-double-left"></span></a>&nbsp;
                      <a href="{{url('/')}}/{{$next}}/edit" title="Next quarter" class="btn btn-danger btn-sm"><span class="fa fa-angle-double-right"></span></a>&nbsp;
                  </span>
                  <span class="btn-group-xs">
                      <button title="Save plan data" class="btn btn-sm btn-danger" type="submit"><span class="fa fa-save"></span></button>
                      <a href="view" title="View a PDF version of the plan" class="btn btn-sm btn-danger"><span class="fa fa-file-pdf-o"></span></a>
                  </span>
              </span>
          </th>
          @foreach ($sundays as $s1)
            <th class="text-center">{{date("j M",$s1['dt'])}}</th>
          @endforeach
        </tr>
    @endif
    @foreach ($soc->service as $ser)
      <tr><th class="text-right">{{$soc->society}}</th><td>{{$ser->servicetime}}</td>
      @foreach ($sundays as $sun)
        <td>
          @if (in_array($soc->id,$authsoc))
            <select class="form-control pplan" name="t_{{$soc->id}}_{{$ser->id}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}"><option></option>
              @foreach ($tags as $tag)
                @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tag'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tag']==$tag->id))
                  <option selected value="{{$tag->id}}">{{$tag->abbr}}</option>
                @else
                  <option value="{{$tag->id}}">{{$tag->abbr}}</option>
                @endif
              @endforeach
            </select>
            <select class="form-control pplan" name="p_{{$soc->id}}_{{$ser->id}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}"><option></option>
              <optgroup label="Ministers">
                @foreach ($ministers as $minister)
                  @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher']=="M_" . $minister->id))
                    <option selected value="M_{{$minister->id}}">{{substr($minister->individual->firstname,0,1)}} {{$minister->individual->surname}}</option>
                  @else
                    <option value="M_{{$minister->id}}">{{substr($minister->individual->firstname,0,1)}} {{$minister->individual->surname}}</option>
                  @endif
                @endforeach
              </optgroup>
              <optgroup label="Preachers">
                @foreach ($preachers as $preacher)
                  @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher']=="P_" . $preacher->id))
                    <option selected value="P_{{$preacher->id}}">{{substr($preacher->individual->firstname,0,1)}} {{$preacher->individual->surname}}</option>
                  @else
                    <option value="P_{{$preacher->id}}">{{substr($preacher->individual->firstname,0,1)}} {{$preacher->individual->surname}}</option>
                  @endif
                @endforeach
              </optgroup>
              <optgroup label="Guests">
                @foreach ($guests as $guest)
                  @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher']=="G_" . $guest->id))
                    <option selected value="G_{{$guest->id}}">{{substr($guest->firstname,0,1)}} {{$guest->surname}}</option>
                  @else
                    <option value="G_{{$guest->id}}">{{substr($guest->firstname,0,1)}} {{$guest->surname}}</option>
                  @endif
                @endforeach
              </optgroup>
            </select>
          @else
            @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tag'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tag']<>""))
              {{$fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tname']}}<br>
            @else

            @endif
            @if ((isset($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher'])) and ($fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['preacher']<>""))
              {{$fin[$soc->society][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['pname']}}
            @endif
         @endif
        </td>
      @endforeach
      </tr>
    @endforeach
    <?php $count++;?>
  @endforeach
  </tbody>
</table>
</div>
{!! Form::close() !!}
@stop
