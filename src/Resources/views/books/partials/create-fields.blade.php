<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsText('author','Author','Author') }}
<div class='form-group '>
  <label for="supplier_id">Supplier</label>
  <select class="selectize" id="supplier_id" name="supplier_id">
    @foreach ($suppliers as $supplier)
      <option value="{{$supplier->id}}">{{$supplier->supplier}}</option>
    @endforeach
  </select>
</div>
{{ Form::bsTextarea('description','Description','Description') }}
{{ Form::bsHidden('image') }}
<div id="thumbdiv" style="margin-bottom:5px;"></div>
<div id="filediv"></div>
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
	@foreach ($tags as $tag)
	  <option value="{{$tag->name}}">{{$tag->name}}</option>
	@endforeach
  </select>
</div>
{{ Form::bsText('sample','Sample','Sample') }}
{{ Form::bsText('stock','No. of copies','No. of copies',1) }}
{{ Form::bsText('saleprice','Sale price','Sale price') }}
{{ Form::bsText('costprice','Cost price','Cost price') }}