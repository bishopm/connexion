<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\RolesRepository;
use bishopm\base\Repositories\PermissionsRepository;
use bishopm\base\Models\Role;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateRoleRequest;
use bishopm\base\Http\Requests\UpdateRoleRequest;

class RolesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $role,$permissions;

	public function __construct(RolesRepository $role, PermissionsRepository $permissions)
    {
        $this->role = $role;
        $this->permissions = $permissions;
    }

	public function index()
	{
        $roles = $this->role->all();
   		return view('base::roles.index',compact('roles'));
	}

	public function edit(Role $role)
    {
        return view('base::roles.edit', compact('role'));
    }

    public function show(Role $role)
    {
        $data['permissions']=$this->permissions->all();
        $data['role']=$role;
        return view('base::roles.show', $data);
    }

    public function create()
    {
        return view('base::roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->role->create($request->all());

        return redirect()->route('admin.roles.index')
            ->withSuccess('New role added');
    }
	
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $this->role->update($role, $request->all());
        return redirect()->route('admin.roles.index')->withSuccess('Role has been updated');
    }

    public function addpermission(Role $role,$permissionid)
    {
        $role->permissions()->attach($permissionid);
    }

    public function removepermission(Role $role,$permissionid)
    {
        $role->permissions()->detach($permissionid);
    }

}