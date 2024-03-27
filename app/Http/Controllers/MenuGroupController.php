<?php

namespace App\Http\Controllers;

use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Services\MenuGroupService;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreMenuGroupRequest;

class MenuGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // If user is not authorized, abort
        if (! Gate::allows('menu_index')) {
            abort(403);
        }
        $menuGroups = MenuGroup::query()
            ->when(! blank($request->search), function ($query) use ($request) {
                return $query
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('permission_name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);
        $permissions = Permission::orderBy('name')->get();

        return view('pages.management-access.menu.index', compact('menuGroups', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If user is not authorized, abort
        if (! Gate::allows('menu_index')) {
            abort(403);
        }
        return view('pages.management-access.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuGroupRequest $request, MenuGroupService $menuGroupService)
    {
        return $menuGroupService->create($request)
            ? back()->with('success', 'Menu group has been created successfully!')
            : back()->with('failed', 'Menu group was not created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // If user is not authorized, abort
        if (! Gate::allows('menu_index')) {
            abort(403);
        }
        return view('pages.management-access.menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // If user is not authorized, abort
        if (! Gate::allows('menu_index')) {
            abort(403);
        }
        return view('pages.management-access.menu.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMenuGroupRequest $request, MenuGroup $menu, MenuGroupService $menuGroupService)
    {
        return $menuGroupService->update($request, $menu)
            ? back()->with('success', 'Menu group has been updated successfully!')
            : back()->with('failed', 'Menu group was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuGroup $menu)
    {
        return $menu->delete()
            ? back()->with('success', 'Menu group has been deleted successfully!')
            : back()->with('failed', 'Menu group was not deleted successfully!');
    }
}
