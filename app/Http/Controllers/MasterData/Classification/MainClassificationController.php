<?php

namespace App\Http\Controllers\MasterData\Classification;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Classification\MainClassification;

class MainClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('main_classification_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.main-classification.index', compact('mainClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('main_classification_create')) {
            abort(403);
        }
        return view('pages.master-data.classification.main-classification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('main_classification_store')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', Rule::unique('classification_mains')],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Klasifikasi harus diisi.',
            'name.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Klasifikasi harus diisi.',
            'code.max' => 'Kode Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Klasifikasi sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);

        // If the validation passes, create the Divisi record
        MainClassification::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.main-classification.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(MainClassification $mainClassification)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('main_classification_edit')) {
            abort(403);
        }
        $mainClassifications = MainClassification::find($id);
        return view('pages.master-data.classification.main-classification.edit', compact('mainClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainClassification $mainClassification)
    {
        if (! Gate::allows('main_classification_update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', Rule::unique('classification_mains')->ignore($mainClassification->id)],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Klasifikasi harus diisi.',
            'name.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Klasifikasi harus diisi.',
            'code.max' => 'Kode Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Klasifikasi sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // get all request from frontsite
        $data = $request->all();

        $mainClassification->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.main-classification.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('main_classification_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $mainClassification = MainClassification::find($decrypt_id);

        /// Check if there are any foreign key relationships
        if ($mainClassification) {
            // Assuming there is a foreign key relationship with another model, e.g., "relatedModel"
            if ($mainClassification->sub_classification()->count() > 0) {
                alert()->error('Gagal', 'Terdapat relasi dengan data lain.');
                return back();
            }

            // No foreign key relationships, proceed with deletion
            $mainClassification->forceDelete();

            alert()->success('Sukses', 'Data berhasil dihapus');
            return back();
        } else {
            alert()->error('Gagal', 'Data tidak ditemukan');
            return back();
        }
    }
}
