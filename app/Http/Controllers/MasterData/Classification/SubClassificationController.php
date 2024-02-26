<?php

namespace App\Http\Controllers\MasterData\Classification;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\MasterData\Classification\MainClassification;

class SubClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subClassifications = SubClassification::orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.sub-classification.index', compact('subClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.sub-classification.create', compact('mainClassifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            'code' => ['required', 'max:255', Rule::unique('classification_subs')],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Sub Klasifikasi harus diisi.',
            'name.max' => 'Nama Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'main_classification_id.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Sub Klasifikasi harus diisi.',
            'code.max' => 'Kode Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Sub Klasifikasi sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        SubClassification::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.sub-classification.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(SubClassification $subClassification)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subClassifications = SubClassification::find($id);
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();

        return view('pages.master-data.classification.sub-classification.edit', compact('subClassifications', 'mainClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubClassification $subClassification)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            'code' => ['required', 'max:255', Rule::unique('classification_subs')->ignore($subClassification->id)],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Sub Klasifikasi harus diisi.',
            'name.max' => 'Nama Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'main_classification_id.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Sub Klasifikasi harus diisi.',
            'code.max' => 'Kode Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Sub Klasifikasi sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // get all request from frontsite
        $data = $request->all();

        $subClassification->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.sub-classification.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        $decrypt_id = decrypt($id);
        $subClassification = SubClassification::find($decrypt_id);

        // hapus location
        $subClassification->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
