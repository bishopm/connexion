{{ Form::bsText('title','Menu item','Menu item') }}
<div class="form-group">
    <label for="target">Target</label>
    <select class="form-control" name="target" id="target">
        <option value="_self">Same tab</option>
        <option value="_blank">New tab</option>
    </select>
</div>
<div class="form-group">
    <label for="target">Page</label>
    <select class="form-control" name="page_id" id="page_id">
    	<option value="0"></option>
    	@foreach ($pages as $page)
    		<option value="{{$page->id}}">{{$page->title}}</option>
    	@endforeach
    </select>
</div>
<div class="form-group">
    <label for="target">Parent menu item</label>
    <select class="form-control" name="parent_id" id="parent_id">
    	<option value="0">Root</option>
    	@foreach ($items as $item)
    		<option value="{{$item->id}}">{{$item->title}}</option>
    	@endforeach
    </select>
</div>
{{ Form::bsHidden('menu_id',$menu) }}