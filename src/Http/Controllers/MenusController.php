<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\MenusRepository;
use bishopm\base\Repositories\MenuitemsRepository;
use bishopm\base\Models\Menu;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateMenuRequest;
use bishopm\base\Http\Requests\UpdateMenuRequest;

class MenusController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $menu, $menuitems;

	public function __construct(MenusRepository $menu, MenuitemsRepository $menuitems)
    {
        $this->menuitems = $menuitems;
        $this->menu = $menu;
    }

	public function index()
	{
        $data['menus'] = $this->menu->all();
   		return view('base::menus.index',$data);
	}

	public function edit(Menu $menu)
    {
        $data['menuitems'] = $this->menuitems->findByAttributes(array('menu_id'=>$menu->id))->get();
        $data['menu'] = $menu;
        return view('base::menus.edit', $data);
    }

    public function create()
    {
        return view('base::menus.create');
    }

    public function store(CreateMenuRequest $request)
    {
        $this->menu->create($request->all());

        return redirect()->route('admin.menus.index')
            ->withSuccess('New menu added');
    }

    public function update(Menu $menu, UpdateMenuRequest $request)
    {
        $this->menu->update($menu, $request->all());
        return redirect()->route('admin.menus.index')->withSuccess('Menu has been updated');
    }

}
