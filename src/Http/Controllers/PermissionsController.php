<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\PermissionsRepository;
use bishopm\base\Models\Permission;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreatePermissionRequest;
use bishopm\base\Http\Requests\UpdatePermissionRequest;

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
   		return view('base::permissions.index',compact('permissions'));
	}

	public function edit(Permission $permission)
    {
        return view('base::permissions.edit', compact('permission'));
    }

    public function create()
    {
        return view('base::permissions.create');
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