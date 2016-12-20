<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class MenuitemsRepository extends EloquentBaseRepository
{
	public function allForMenu($id)
    {
        return $this->model->where('menu_id',$id)->orderBy('parent_id', 'ASC')->orderBy('position', 'ASC')->get();
    }

    public function arrayForMenu($id)
    {
        $items=$this->model->where('menu_id',$id)->where('parent_id',0)->get();
        $fin="<ol class=\"dd-list\">";
        foreach ($items as $item){
        	$fin.="<li class=\"dd-item\" data-id=\"" . $item->id . "\">\n";
			$fin.="<div class=\"dd-handle\">" . $item->title . "</div>\n";
			$children = $this->model->where('parent_id',$item->id)->get();
			if (count($children)){
				$fin.="<ol class=\"dd-list\">\n";
				foreach ($children as $child){
		            $fin.="<li class=\"dd-item\" data-id=\"" . $child->id . "\">\n";
	                $fin.="<div class=\"dd-handle\">" . $child->title . "</div>\n";
	                $grandchildren = $this->model->where('parent_id',$child->id)->get();
	                if (count($grandchildren)){
						$fin.="<ol class=\"dd-list\">\n";
						foreach ($grandchildren as $gchild){
				            $fin.="<li class=\"dd-item\" data-id=\"" . $gchild->id . "\">\n";
			                $fin.="<div class=\"dd-handle\">" . $gchild->title . "</div>\n";
				            $fin.="</li>";
				        }
			            $fin.="</ol>\n";
					}
		            $fin.="</li>";
		        }
	            $fin.="</ol>\n";
			}
			$fin.="</li>\n";
        }
        return $fin;
    }

    public function makeMenu($id)
    {
	    $items=$this->model->where('menu_id',$id)->where('parent_id',0)->get();
        $fin=array();
        foreach ($items as $item){
        	if ($item->url){
	        	$fin[$item->url] = $item->title;
	        } else {
	        	$fin['#']=$item->title;
	        }
        }
        return $fin;
    }
}
