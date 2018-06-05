@extends('connexion::templates.backend')

@section('css')
<style media="screen" type="text/css">
select.form-control.pplan {
    padding:0px;
    font-size:12px;
    height:auto;
}
.btn-toolbar {
    margin-left: 0; 
}
</style>
@stop

@section('content')
<div class="container-fluid">
@include('connexion::shared.errors')
</div>
{!! Form::open() !!}
<div class="container-fluid">
@if (count($societies))
<table class="table table-condensed table-striped table-responsive table-hover">
  <thead>
    <tr>
      <th colspan="2" class="text-right">
          <span class="btn-toolbar">
              <span class="btn-group-xs">
                  <a href="{{url('/')}}/admin/{{$prev}}/edit" title="Previous quarter" class="btn btn-primary btn-sm"><span class="fa fa-angle-double-left"></span></a>&nbsp;
                  <a href="{{url('/')}}/admin/{{$next}}/edit" title="Next quarter" class="btn btn-primary btn-sm"><span class="fa fa-angle-double-right"></span></a>&nbsp;
              </span>
              <span class="btn-group-xs">
                  <a href="view" title="View a PDF version of the plan" class="btn btn-sm btn-primary"><span class="fa fa-file-pdf-o"></span></a>
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
                      <a href="{{url('/')}}/admin/{{$prev}}/edit" title="Previous quarter" class="btn btn-primary btn-sm"><span class="fa fa-angle-double-left"></span></a>&nbsp;
                      <a href="{{url('/')}}/admin/{{$next}}/edit" title="Next quarter" class="btn btn-primary btn-sm"><span class="fa fa-angle-double-right"></span></a>&nbsp;
                  </span>
                  <span class="btn-group-xs">
                      <a href="view" title="View a PDF version of the plan" class="btn btn-sm btn-primary"><span class="fa fa-file-pdf-o"></span></a>
                  </span>
              </span>
          </th>
          @foreach ($sundays as $s1)
            <th class="text-center">{{date("j M",$s1['dt'])}}</th>
          @endforeach
        </tr>
    @endif
    @foreach ($soc['services'] as $ser)
      <tr><th class="text-right">{{$soc['society']}}</th><td>{{$ser['servicetime']}}</td>
      @foreach ($sundays as $sun)
        <td>
          <select onchange="updateplan('t_{{$soc['id']}}_{{$ser['id']}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}');" class="form-control pplan" id="t_{{$soc['id']}}_{{$ser['id']}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}"><option value="blank"></option>
            <optgroup label="Special services">
              @foreach ($labels as $label)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['tname'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['tname']==$label))
                  <option selected value="{{$label}}">{{$label}}</option>
                @else
                  <option value="{{$label}}">{{$label}}</option>
                @endif
              @endforeach
            </optgroup>
            <optgroup label="Trial service markers">
              @foreach ($ministers as $minister)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial']==$minister['id']))
                  <option selected value="{{$minister['id']}}">{{substr($minister['firstname'],0,1)}} {{$minister['surname']}}</option>
                @else
                  <option value="{{$minister['id']}}">{{substr($minister['firstname'],0,1)}} {{$minister['surname']}}</option>
                @endif
              @endforeach
              @foreach ($supernumeraries as $super)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial']==$super['id']))
                  <option selected value="{{$super['id']}}">{{substr($super['firstname'],0,1)}} {{$super['surname']}}</option>
                @else
                  <option value="{{$super['id']}}">{{substr($super['firstname'],0,1)}} {{$super['surname']}}</option>
                @endif
              @endforeach
              @foreach ($preachers as $preacher)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial']==$preacher['id']))
                  <option selected value="{{$preacher['id']}}">{{substr($preacher['firstname'],0,1)}} {{$preacher['surname']}}</option>
                @else
                  <option value="{{$preacher['id']}}">{{substr($preacher['firstname'],0,1)}} {{$preacher['surname']}}</option>
                @endif
              @endforeach
            </optgroup>
          </select>
          <select onchange="updateplan('p_{{$soc['id']}}_{{$ser['id']}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}');" class="form-control pplan" id="p_{{$soc['id']}}_{{$ser['id']}}_{{$sun['yy']}}_{{$sun['mm']}}_{{$sun['dd']}}"><option value="blank"></option>
            <optgroup label="Ministers">
              @foreach ($ministers as $minister)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher']=="M_" . $minister['id']))
                  <option selected value="M_{{$minister['id']}}">{{substr($minister['firstname'],0,1)}} {{$minister['surname']}}</option>
                @else
                  <option value="M_{{$minister['id']}}">{{substr($minister['firstname'],0,1)}} {{$minister['surname']}}</option>
                @endif
              @endforeach
            </optgroup>
            <optgroup label="Supernumeraries">
              @foreach ($supernumeraries as $super)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher']=="G_" . $super['id']))
                  <option selected value="G_{{$super['id']}}">{{substr($super['firstname'],0,1)}} {{$super['surname']}}</option>
                @else
                  <option value="G_{{$super['id']}}">{{substr($super['firstname'],0,1)}} {{$super['surname']}}</option>
                @endif
              @endforeach
            </optgroup>
            <optgroup label="Preachers">
              @foreach ($preachers as $preacher)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher']=="P_" . $preacher['id']))
                  <option selected value="P_{{$preacher['id']}}">{{substr($preacher['firstname'],0,1)}} {{$preacher['surname']}}</option>
                @else
                  <option value="P_{{$preacher['id']}}">{{substr($preacher['firstname'],0,1)}} {{$preacher['surname']}}</option>
                @endif
              @endforeach
            </optgroup>
            <optgroup label="Guests">
              @foreach ($guests as $guest)
                @if ((isset($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher'])) and ($fin[$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['preacher']=="G_" . $guest['id']))
                  <option selected value="G_{{$guest['id']}}">{{substr($guest['firstname'],0,1)}} {{$guest['surname']}}</option>
                @else
                  <option value="G_{{$guest['id']}}">{{substr($guest['firstname'],0,1)}} {{$guest['surname']}}</option>
                @endif
              @endforeach
            </optgroup>            
          </select>
        </td>
      @endforeach
      </tr>
    @endforeach
    <?php $count++;?>
  @endforeach
  </tbody>
</table>
@else
  No societies or preaching places have been set up yet. <a class="btn btn-primary" href="{{url('/')}}/admin/societies">Add a society</a>
@endif
</div>
{!! Form::close() !!}
@stop
@section('js')
<script language="javascript">
  function updateplan(box){
    val=$('#'+box).val();
    circuit={{$setting['circuit']}};
    $.ajax({
      type : 'GET',
      url : '{{url('/')}}/admin/plan/update/' + circuit + '/' + box + '/' + val,
    });
  }
</script>
@stop
