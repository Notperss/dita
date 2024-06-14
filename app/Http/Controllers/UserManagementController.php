<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Models\MasterData\Company\Company;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\MasterData\WorkUnits\Division;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (! Gate::allows('user_index')) {
            abort(403);
        }

        $company_id = auth()->user()->company_id;
        if (Gate::allows('super_admin')) {
            $users = User::query()
                ->when(! blank($request->search), function ($query) use ($request) {
                    return $query
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->with('roles', function ($query) {
                    return $query->select('name');
                })
                ->latest()
                ->paginate(10);
            $roles = Role::orderBy('name')->get();

            $companies = Company::orderBy('name')->get();

            // $userCompany = User::orderBy('name')->get();
            // $companyUser = $userCompany->company_id;

            $divisions = Division::orderBy('name')->get();

        } else {

            $users = User::query()
                ->when(! blank($request->search), function ($query) use ($request) {
                    return $query
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->with('roles', function ($query) {
                    return $query->select('name');
                }, 'company')
                ->latest()
                ->where('company_id', $company_id)
                ->paginate(10);

            $roles = Role::orderBy('name')->get();

            $companies = Company::where('id', $company_id)->orderBy('name')->get();

            $divisions = Division::where('company_id', $company_id)->orderBy('name')->get();
        }


        // $users = User::query()
        //     ->when(! blank($request->search), function ($query) use ($request) {
        //         return $query
        //             ->where('name', 'like', '%' . $request->search . '%')
        //             ->orWhere('email', 'like', '%' . $request->search . '%');
        //     })
        //     ->with('roles', function ($query) {
        //         return $query->select('name');
        //     })
        //     ->latest()
        //     ->paginate(10);
        // $roles = Role::orderBy('name')->get();

        // $companies = Company::orderBy('name')->get();

        // $divisions = Division::orderBy('name')->get();

        return view('pages.management-access.user.index', compact('users', 'roles', 'companies', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('user_store')) {
            abort(403);
        }
        return view('pages.management-access.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $userService)
    {
        return $userService->create($request)
            ? back()->with('success', 'User has been created successfully!')
            : back()->with('failed', 'User was not created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.management-access.user.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! Gate::allows('user_update')) {
            abort(403);
        }
        return view('pages.management-access.user.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        return $userService->update($request, $user)
            ? back()->with('success', 'User has been updated successfully!')
            : back()->with('failed', 'User was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $user->delete()
            ? back()->with('success', 'User has been deleted successfully!')
            : back()->with('failed', 'User was not deleted successfully!');
    }

    public function getDivisions(Request $request)
    {
        $companyId = $request->input('company_id');
        $division = Division::where('company_id', $companyId)->get();
        return response()->json($division);
    }
}
