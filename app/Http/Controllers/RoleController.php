<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        // Use correct Permission model
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

 public function store(Request $request)
{
  dd($request->all());
    $request->validate([
        'name' => 'required|unique:roles,name',
        'guard_name' => 'nullable|string',
    ]);

    // No 'id' field required — model will generate UUID
    $role = Role::create([
        'name' => $request->name,
        'guard_name' => $request->guard_name ?? 'web',
    ]);

    if ($request->permissions) {
        $role->syncPermissions($request->permissions);
    }

    return redirect()->route('roles.index')
                     ->with('success', 'Role created successfully.');
}



    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'guard_name' => 'nullable|string'
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')
                         ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
