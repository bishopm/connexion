    <h3>
        {{$pgtitle}}
    </h3>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{$prevroute}}">{{$prevtitle}}</a></li>
        <li class="active">{{$pgtitle}}</li>
    </ol>
