<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (! Gate::allows('role_index')) {
            abort(403);
        }
        $roles = Role::query()
            ->when(! blank($request->search), function ($query) use ($request) {
                return $query
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('guard_name', 'like', '%' . $request->search . '%');
            })
            ->with('permissions', function ($query) {
                return $query->select('id', 'name');
            })
            ->orderBy('name')
            ->paginate(10);
        $permissions = Permission::orderBy('name')->get();

        return view('pages.management-access.role.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('role_create')) {
            abort(403);
        }
        return view('pages.management-access.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        return Role::create($request->validated())
                ?->givePermissionTo(! blank($request->permissions) ? $request->permissions : array())
            ? back()->with('success', 'Role has been created successfully!')
            : back()->with('failed', 'Role was not created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (! Gate::allows('role_index')) {
            abort(403);
        }
        return view('pages.management-access.role.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! Gate::allows('role_update')) {
            abort(403);
        }
        return view('pages.management-access.role.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        return $role->update($request->validated())
            && $role->syncPermissions(! blank($request->permissions) ? $request->permissions : array())
            ? back()->with('success', 'Role has been updated successfully!')
            : back()->with('failed', 'Role was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        return $role->delete()
            ? back()->with('success', 'Role has been deleted successfully!')
            : back()->with('failed', 'Role was not deleted successfully!');
    }
}
