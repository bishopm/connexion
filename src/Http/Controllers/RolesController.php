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
        $permissions=array('edit-backend','edit-comments','edit-worship','view-backend','view-worship','admin-backend','edit-bookshop');
        return view('connexion::roles.edit', compact('role','permissions'));
    }

    public function create()
    {
        $permissions=array('edit-backend','edit-comments','edit-worship','view-backend','view-worship','admin-backend','edit-bookshop');
        return view('connexion::roles.create',compact('permissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        $role=new Role();
        $role->name=$request->input('name');
        $role->slug = $request->input('slug');
        $perms=array();
        foreach ($request->input('permissions') as $perm){
            $perms[$perm]=true;
        }
        $role->permissions=$perms;
        $role->save();
        return redirect()->route('admin.roles.index')
            ->withSuccess('New role added');
    }
	
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->name=$request->input('name');
        $role->slug = $request->input('slug');
        $perms=array();
        foreach ($request->input('permissions') as $perm){
            $perms[$perm]=true;
        }
        $role->permissions=$perms;
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