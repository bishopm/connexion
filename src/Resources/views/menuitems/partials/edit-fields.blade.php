{{ Form::bsText('title','Menu item','Menu item',$menuitem->title) }}
<div class="form-group">
    <label for="target">Target</label>
    <select class="form-control" name="target" id="target">
    	@if ($menuitem->target=="_self")
	        <option selected value="_self">Same tab</option>
	        <option value="_blank">New tab</option>
	    @else
			<option value="_self">Same tab</option>
	        <option selected value="_blank">New tab</option>
	    @endif
    </select>
</div>
<div class="form-group">
    <label for="target">Page</label>
    <select class="form-control" name="page_id" id="page_id">
    	<option value="0"></option>
    	@foreach ($pages as $page)
    		@if ($menuitem->page_id==$page->id)
	    		<option selected value="{{$page->id}}">{{$page->title}}</option>
	    	@else
	    		<option value="{{$page->id}}">{{$page->title}}</option>
	    	@endif
    	@endforeach
    </select>
</div>
<div class="form-group">
    <label for="target">Parent menu item</label>
    <select class="form-control" name="parent_id" id="parent_id">
    	<option value="0">Root</option>
    	@foreach ($items as $item)
    	    @if ($menuitem->parent_id==$item->id)
    			<option selected value="{{$item->id}}">{{$item->title}}</option>
    		@else
				<option value="{{$item->id}}">{{$item->title}}</option>
    		@endif
    	@endforeach
    </select>
</div>
{{ Form::bsHidden('menu_id',$menu) }}