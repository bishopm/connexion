<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PermissionsRepository;
use Spatie\Permission\Models\Permission;
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

	public function __construct(PermissionsRepository $permission)
    {
        $this->permission = $permission;
    }

	public function index()
	{
        $permissions = $this->permission->all();
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
        $this->permission->create($request->all());

        return redirect()->route('admin.permissions.index')
            ->withSuccess('New permission added');
    }
	
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $this->permission->update($permission, $request->all());
        return redirect()->route('admin.permissions.index')->withSuccess('Permission has been updated');
    }

}