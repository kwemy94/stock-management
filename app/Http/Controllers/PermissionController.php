<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy('group');

        $roles = Role::with('permissions')->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }


    public function editUserPermissions(User $user)
{
    $permissions = Permission::orderBy('group')
        ->orderBy('name')
        ->get()
        ->groupBy('group');

    $userPermissions = $user->permissions->pluck('id')->toArray();

    return view(
        'admin.permissions.user',
        compact('user', 'permissions', 'userPermissions')
    );
}

public function updateUserPermissions(Request $request, User $user)
{
    $permissionIds = $request->input('permissions', []);

    $user->permissions()->sync($permissionIds);

    return redirect()
        ->back()
        ->with('success', 'Permissions mises à jour avec succès.');
}

}
