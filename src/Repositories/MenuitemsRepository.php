<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Menu;

class MenuitemsRepository extends EloquentBaseRepository
{
    public function allForMenu($id)
    {
        return $this->model->where('menu_id', $id)->orderBy('parent_id', 'ASC')->get();
    }

    public function allMain($id)
    {
        return $this->model->where('menu_id', $id)->where('parent_id', 0)->get();
    }

    public function arrayForMenu($id)
    {
        $items=$this->model->where('menu_id', $id)->where('parent_id', 0)->orderBy('position', 'ASC')->get();
        $fin="<ol class=\"dd-list\">";
        foreach ($items as $item) {
            $fin.="<li class=\"dd-item\" data-id=\"" . $item->id . "\">\n";
            $fin.="<div class=\"btn-group\" role=\"group\" aria-label=\"Action buttons\" style=\"display: inline\"><a class=\"btn btn-sm btn-info\" style=\"float:left;\" href=\"" . route('admin.menuitems.edit', array($id,$item->id)) . "\"><i class=\"fa fa-pencil\"></i></a><a class=\"btn btn-sm btn-danger jsDeleteMenuItem\" style=\"float:left; margin-right: 15px;\" data-item-id=\"" . $item->id . "\"><i class=\"fa fa-times\"></i></a></div>";
            $fin.="<div class=\"dd-handle\">" . $item->title . "</div>\n";
            $children = $this->model->where('parent_id', $item->id)->orderBy('position')->get();
            if (count($children)) {
                $fin.="<ol class=\"dd-list\">\n";
                foreach ($children as $child) {
                    $fin.="<li class=\"dd-item\" data-id=\"" . $child->id . "\">\n";
                    $fin.="<div class=\"btn-group\" role=\"group\" aria-label=\"Action buttons\" style=\"display: inline\"><a class=\"btn btn-sm btn-info\" style=\"float:left;\" href=\"" . route('admin.menuitems.edit', array($id,$child->id)) . "\"><i class=\"fa fa-pencil\"></i></a><a class=\"btn btn-sm btn-danger jsDeleteMenuItem\" style=\"float:left; margin-right: 15px;\" data-item-id=\"" . $child->id . "\"><i class=\"fa fa-times\"></i></a></div>";
                    $fin.="<div class=\"dd-handle\">" . $child->title . "</div>\n";
                    $grandchildren = $this->model->where('parent_id', $child->id)->get();
                    if (count($grandchildren)) {
                        $fin.="<ol class=\"dd-list\">\n";
                        foreach ($grandchildren as $gchild) {
                            $fin.="<li class=\"dd-item\" data-id=\"" . $gchild->id . "\">\n";
                            $fin.="<div class=\"btn-group\" role=\"group\" aria-label=\"Action buttons\" style=\"display: inline\"><a class=\"btn btn-sm btn-info\" style=\"float:left;\" href=\"" . route('admin.menuitems.edit', array($id,$gchild->id)) . "\"><i class=\"fa fa-pencil\"></i></a><a class=\"btn btn-sm btn-danger jsDeleteMenuItem\" style=\"float:left; margin-right: 15px;\" data-item-id=\"" . $gchild->id . "\"><i class=\"fa fa-times\"></i></a></div>";
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
        $this->items=$this->model->where('menu_id', $id)->where('parent_id', 0)->orderBy('position', 'ASC')->get();
        Menu::create('mainmenu', function ($menu) {
            $menu->setPresenter(\Bishopm\Connexion\Presenters\Bootstrap4Presenter::class);
            foreach ($this->items as $item) {
                $this->children = $this->model->where('parent_id', $item->id)->orderBy('position', 'ASC')->get();
                if (!count($this->children)) {
                    if ($item->url) {
                        $menu->url(url(strtolower($item->url)), $item->title);
                    } else {
                        $menu->url('#', $item->title);
                    }
                } else {
                    $menu->dropdown($item->title, function ($sub) {
                        foreach ($this->children as $child) {
                            if ($child->url) {
                                $sub->url(url(strtolower($child->url)), $child->title);
                            } else {
                                $sub->url('#', $child->title);
                            }
                        }
                    });
                }
            }
        });
        return Menu::get('mainmenu');
    }

    public function makeFooter($id)
    {
        $items=$this->model->where('menu_id', $id)->where('parent_id', 0)->orderBy('position', 'ASC')->get();
        $mainfooter=array();
        foreach ($items as $menu) {
            $children = $this->model->where('parent_id', $menu->id)->orderBy('position', 'ASC')->get();
            foreach ($children as $child) {
                $mainfooter[$menu->title][]='<a href="' . url('/') . '/' . $child->url . '">' . $child->title . '</a>';
            }
        }
        return $mainfooter;
    }
}
