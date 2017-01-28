<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\MenusRepository;
use Bishopm\Connexion\Repositories\MenuitemsRepository;
use Bishopm\Connexion\Models\Menu;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateMenuRequest;
use Bishopm\Connexion\Http\Requests\UpdateMenuRequest;

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
   		return view('connexion::menus.index',$data);
	}

	public function edit(Menu $menu)
    {
        $data['menuitems'] = $this->menuitems->arrayForMenu($menu->id);
        $data['menu'] = $menu;
        return view('connexion::menus.edit', $data);
    }

    public function create()
    {
        return view('connexion::menus.create');
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
