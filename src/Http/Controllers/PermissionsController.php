<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Models\Permission;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePermissionRequest;
use Bishopm\Connexion\Http\Requests\UpdatePermissionRequest;

class PermissionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $permission;

	public function __construct()
    {
        //
    }

	public function index()
	{
        $permissions = Permission::all();
   		return view('connexion::permissions.index',compact('permissions'));
	}

	public function edit(Permission $permission)
    {
        return view('connexion::permissions.edit', compact('permission'));
    }

    public function create()
    {
        return view('connexion::permissions.create');
    }

    public function store(CreatePermissionRequest $request)
    {
        $permission=new Permission();
        $permission->name=$request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description  = $request->input('description');
        $permission->save();
        return redirect()->route('admin.permissions.index')
            ->withSuccess('New permission added');
    }
	
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $permission->name=$request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description  = $request->input('description');
        $permission->save();
        return redirect()->route('admin.permissions.index')->withSuccess('Permission has been updated');
    }

}