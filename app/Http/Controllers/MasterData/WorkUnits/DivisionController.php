<?php

namespace App\Http\Controllers\MasterData\WorkUnits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Division;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('division_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $divisions = Division::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('division_create')) {
            abort(403);
        }
        return view('pages.master-data.work-units.division.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('division_store')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'max:255', Rule::unique('divisions')],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Divisi harus diisi.',
            'code.required' => 'Kode harus diisi.',
            'name.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            'code.max' => 'Kode tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        // If the validation passes, create the MainLocation record

        // If the validation passes, create the Divisi record
        Division::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('division.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('division_edit')) {
            abort(403);
        }
        $divisions = Division::find($id);
        return view('pages.master-data.work-units.division.edit', compact('divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        if (! Gate::allows('division_update')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'max:255', Rule::unique('divisions')->ignore($division->id)],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Divisi harus diisi.',
            'code.required' => 'Kode harus diisi.',
            'name.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            'code.max' => 'Kode tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $division->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('division.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('division_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $division = Division::find($decrypt_id);

        // hapus location
        $division->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
