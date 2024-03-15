<?php

namespace App\Http\Controllers\MasterData\WorkUnits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\MasterData\WorkUnits\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('department_index')) {
            abort(403);
        }
        $departments = Department::with('division')->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('department_create')) {
            abort(403);
        }
        $divisions = Division::orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.department.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('department_store')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'division_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Departemen harus diisi.',
            'division_id.required' => 'Nama Divisi harus diisi.',
            'name.max' => 'Nama Departemen tidak boleh lebih dari :max karakter.',
            'division_id.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        Department::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.department.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('department_edit')) {
            abort(403);
        }
        $departments = Department::find($id);
        $divisions = Division::orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.department.edit', compact('departments', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        if (! Gate::allows('department_update')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'division_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Departemen harus diisi.',
            'division_id.required' => 'Nama Divisi harus diisi.',
            'name.max' => 'Nama Departemen tidak boleh lebih dari :max karakter.',
            'division_id.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $department->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('department_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $department = Department::find($decrypt_id);

        // hapus location
        $department->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
