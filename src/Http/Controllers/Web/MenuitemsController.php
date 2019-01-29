<?php

namespace Bishopm\Connexion\Http\Controllers\Web;

use Bishopm\Connexion\Repositories\MenuitemsRepository;
use Bishopm\Connexion\Repositories\PagesRepository;
use Bishopm\Connexion\Models\Menuitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateMenuitemRequest;
use Bishopm\Connexion\Http\Requests\UpdateMenuitemRequest;
use Illuminate\Support\Facades\DB;

class MenuitemsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $menuitem, $pages;

	public function __construct(MenuitemsRepository $menuitem, PagesRepository $pages)
    {
        $this->menuitem = $menuitem;
        $this->pages = $pages;
    }

	public function index($menu)
	{
        $data['menuitems'] = $this->menuitem->all();
        $data['menu'];
   		return view('connexion::menuitems.index',$data);
	}

	public function edit($menu,Menuitem $menuitem)
    {
        $data['pages']=$this->pages->all();
        $data['items']=$this->menuitem->all();
        $data['menuitem']=$menuitem;
        $data['menu']=$menu;
        return view('connexion::menuitems.edit', $data);
    }

    public function create($menu)
    {
        $data['pages']=$this->pages->all();
        $data['items']=$this->menuitem->allMain($menu);
        $data['menu']=$menu;
        return view('connexion::menuitems.create',$data);
    }

    public function store(CreateMenuitemRequest $request)
    {
        $this->menuitem->create($request->all());

        return redirect()->route('admin.menus.edit',$request->menu_id)
            ->withSuccess('New menu item added');
    }

    public function update($menu, Menuitem $menuitem, UpdateMenuitemRequest $request)
    {
        $this->menuitem->update($menuitem, $request->all());
        return redirect()->route('admin.menus.edit',$menu)->withSuccess('Menuitem has been updated');
    }

    public function reorder(Request $request)
    {
        $items=json_decode($request->menu);
        foreach ($items as $key=>$item){
            $item1=$this->menuitem->find($item->id);
            $item1->parent_id=0;
            $item1->position=$key;
            $item1->save();
            if (isset($item->children)){
                foreach ($item->children as $key2=>$child){
                    $item2=$this->menuitem->find($child->id);
                    $item2->parent_id=$item->id;
                    $item2->position=$key2;
                    $item2->save();
                    if (isset($child->children)){
                        foreach ($child->children as $key3=>$grandchild){
                            $item3=$this->menuitem->find($grandchild->id);
                            $item3->parent_id=$child->id;
                            $item3->position=$key3;
                            $item3->save();
                        }
                    }
                }
            }
        }
        print "Done!";
    }

    public function destroy($menu, Menuitem $menuitem)
    {
        $this->menuitem->destroy($menuitem);

        return redirect()->route('admin.menus.edit',$menu)->withSuccess('Menu item has been deleted');
    }

}
