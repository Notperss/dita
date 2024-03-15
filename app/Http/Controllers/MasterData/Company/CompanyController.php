<?php

namespace App\Http\Controllers\MasterData\Company;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Company\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('company_index')) {
            abort(403);
        }

        $companies = Company::orderBy('name', 'asc')->get();

        return view('pages.master-data.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('company_create')) {
            abort(403);
        }
        return view('pages.master-data.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('company_store')) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('companies')],
            'address' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],



            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Perusahaan harus diisi.',
            'name.max' => 'Nama Perusahaan tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama Perusahaan sudah digunakan.',

            'address.required' => 'Alamat Perusahaan harus diisi.',
            'address.max' => 'Alamat Perusahaan tidak boleh lebih dari :max karakter.',

            'description.required' => 'Keterangan harus diisi.',
            'description.max' => 'Keterangan tidak boleh lebih dari :max karakter.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        Company::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('company_edit')) {
            abort(403);
        }
        $companies = Company::find($id);
        return view('pages.master-data.company.edit', compact('companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        if (! Gate::allows('company_update')) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('companies')],
            'address' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],



            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Perusahaan harus diisi.',
            'name.max' => 'Nama Perusahaan tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama Perusahaan sudah digunakan.',

            'address.required' => 'Alamat Perusahaan harus diisi.',
            'address.max' => 'Alamat Perusahaan tidak boleh lebih dari :max karakter.',

            'description.required' => 'Keterangan harus diisi.',
            'description.max' => 'Keterangan tidak boleh lebih dari :max karakter.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        $data = $request->all();

        $company->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('company_destroy')) {
            abort(403);
        }
        // Decrypt id
        $decrypt_id = decrypt($id);
        $company = Company::find($decrypt_id);

        // Delete
        $company->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
