@extends('connexion::templates.backend')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/croppie.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit Book','Books',route('admin.books.index')) }}
@stop

@section('content')
    <div class="nav-tabs well">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active">
                <a href="#editbook" data-toggle="tab">Edit book</a>
            </li>
            <li>
                <a href="#transtab" data-toggle="tab">Transaction history</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active" id="editbook">
                @include('connexion::shared.errors')
                {!! Form::open(['route' => array('admin.books.update',$book->id), 'method' => 'put', 'files'=>'true']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary"> 
                            <div class="box-body">
                                @include('connexion::books.partials.edit-fields')
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat">Update</button>
                                <a class="btn btn-danger pull-right btn-flat" href="{{route('admin.books.index')}}"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                @include('connexion::shared.filemanager-modal',['folder'=>'books'])
            </div>
            <div class="tab-pane" id="transtab">
                <div class="panel-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th><th>Book</th><th>Amount</th><th>Quantity</th><th>Type</th><th>Notes</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th><th>Book</th><th>Amount</th><th>Quantity</th><th>Type</th><th>Notes</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->transactiondate}}</td>
                                    <td>{{$transaction->book->title}}</td>
                                    <td>{{$transaction->unitamount}}</td>
                                    <td>{{$transaction->units}}</td>
                                    <td>{{$transaction->transactiontype}}</td>
                                    <td>{{$transaction->details}}</td>
                                </tr>
                            @empty
                                <tr><td>No transactions have been added yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <label>Current Stock:</label> {{$book->stock}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
@parent
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote-cleaner@1.0.0/summernote-cleaner.min.js" type="text/javascript"></script>
<script src="{{ asset('/vendor/bishopm/js/croppie.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $( document ).ready(function() {
        $('#title').on('input', function() {
            var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
            $("#slug").val(slug);
        });
        $('#indexTable').DataTable();
        $('#description').summernote({ 
              height: 250,
              toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['table', ['table']],
                ['link', ['linkDialogShow', 'unlink']],
                ['view', ['fullscreen', 'codeview']],
                ['para', ['ul', 'ol', 'paragraph']]
              ],
              cleaner:{
                notTime: 2400, // Time to display Notifications.
                action: 'paste', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<p></p>', // Summernote's default is to use '<p><br></p>'
                notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                icon: '<i class="note-icon">[Your Button]</i>',
                keepHtml: false, // Remove all Html formats
                keepClasses: false, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'font', 'noscript', 'html'], 
                badAttributes: ['style', 'start','p'] // Remove attributes from remaining tags
              }
            });
        $('.input-tags').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
          dropdownParent: "body",
          create: function(value) {
              return {
                  value: value,
                  text: value
              }
          },
          onItemAdd: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/books/addtag/{{$book->id}}/" + value })
          },
          onItemRemove: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/books/removetag/{{$book->id}}/" + value })
          }
        });
        $('.selectize').selectize();
    });
    @include('connexion::shared.filemanager-modal-script',['folder'=>'books','width'=>250,'height'=>250])
</script>
@endsection