<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\SettingService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('route_index')) {
            abort(403);
        }
        $setting = Setting::first();
        $roles = Role::all();
        $data = json_decode($setting->data);

        return view('pages.management-access.setting.index', compact('setting', 'roles', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('route_create')) {
            abort(403);
        }
        return view('pages.management-access.setting.create');
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
    public function show(string $id)
    {
        if (! Gate::allows('route_show')) {
            abort(403);
        }
        return view('pages.management-access.setting.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! Gate::allows('route_edit')) {
            abort(403);
        }
        return view('pages.management-access.setting.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, Setting $setting, SettingService $settingService)
    {
        return $settingService->update($request, $setting)
            ? back()->with('success', 'Setting has been updated successfully!')
            : back()->with('failed', 'Setting was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
