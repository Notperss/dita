<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Services\RouteService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRouteRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route as FacadesRoute;


class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (! Gate::allows('route_index')) {
            abort(403);
        }
        $routes = Route::query()
            ->when(! blank($request->search), function ($query) use ($request) {
                return $query
                    ->where('route', 'like', '%' . $request->search . '%')
                    ->orWhere('permission_name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('route')
            ->get();
        $facadesRoutes = FacadesRoute::getRoutes();

        $permissions = Permission::orderBy('name')->get();

        return view('pages.management-access.route.index', compact('routes', 'permissions', 'facadesRoutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('route_store')) {
            abort(403);
        }
        return view('pages.management-access.route.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRouteRequest $request, RouteService $routeService)
    {
        return $routeService->create($request)
            ? back()->with('success', 'Route has been created successfully!')
            : back()->with('failed', 'Route was not created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (! Gate::allows('route_index')) {
            abort(403);
        }
        return view('pages.management-access.route.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! Gate::allows('route_update')) {
            abort(403);
        }
        return view('pages.management-access.route.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRouteRequest $request, Route $route, RouteService $routeService)
    {
        return $routeService->update($request, $route)
            ? back()->with('success', 'Route has been updated successfully!')
            : back()->with('failed', 'Route was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        return $route->delete()
            ? back()->with('success', 'Route has been deleted successfully!')
            : back()->with('failed', 'Route was not deleted successfully!');
    }
}
