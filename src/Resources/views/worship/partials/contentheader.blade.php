<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ $page_title or "Page title" }}
        <small>{{ $page_description or "Page description" }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{{$breadcrumbs or "Breadcrumb"}}</li>
    </ol>
</section>
