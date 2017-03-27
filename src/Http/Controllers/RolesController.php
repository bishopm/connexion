<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Models\Role;
use Bishopm\Connexion\Models\Permission;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateRoleRequest;
use Bishopm\Connexion\Http\Requests\UpdateRoleRequest;

class RolesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
        $roles = Role::all();
   		return view('connexion::roles.index',compact('roles'));
	}

	public function edit(Role $role)
    {
        return view('connexion::roles.edit', compact('role'));
    }

    public function show(Role $role)
    {
        $data['role']=$role;
        $data['permissions']=Permission::all();
        return view('connexion::roles.show', $data);
    }

    public function create()
    {
        return view('connexion::roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $role=new Role();
        $role->name=$request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description  = $request->input('description');
        $role->save();
        return redirect()->route('admin.roles.index')
            ->withSuccess('New role added');
    }
	
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->name=$request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description  = $request->input('description');
        $role->save();
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