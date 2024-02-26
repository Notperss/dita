<?php

namespace App\Http\Controllers\MasterData\Classification;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Classification\MainClassification;

class MainClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.main-classification.index', compact('mainClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.master-data.classification.main-classification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        MainClassification::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.main-classification.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(MainClassification $mainClassification)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mainClassifications = MainClassification::find($id);
        return view('pages.master-data.classification.main-classification.edit', compact('mainClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainClassification $mainClassification)
    {
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
        // deskripsi id
        $decrypt_id = decrypt($id);
        $mainClassification = MainClassification::find($decrypt_id);

        // hapus location
        $mainClassification->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
