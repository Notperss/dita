<?php

namespace App\Http\Controllers\MasterData\Classification;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        if (! Gate::allows('sub_classification_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        // $subClassifications = SubClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('classification_subs.company_id', $company_id)->leftJoin('classification_mains', 'classification_subs.main_classification_id', '=', 'classification_mains.id')
            ->select('classification_subs.*')
            ->orderBy('classification_mains.name')
            ->orderBy('classification_subs.name', 'asc')
            ->get();

        return view('pages.master-data.classification.sub-classification.index', compact('subClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_id = auth()->user()->company_id;

        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.sub-classification.create', compact('mainClassifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sub_classification_create')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            // 'code' => ['required', 'max:255',],
            'type_document' => ['required', 'max:255',],
            'period_active' => ['required', 'max:255',],
            'period_inactive' => ['required', 'max:255',],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Sub Klasifikasi harus diisi.',
            'name.max' => 'Nama Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'main_classification_id.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Sub Klasifikasi harus diisi.',
            'type_document.required' => 'Tipe Dokumen harus diisi.',
            'period_active.required' => 'Masa Aktif harus diisi.',
            'period_inactive.required' => 'Masa Inaktif harus diisi.',
            'code.max' => 'Kode Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Sub Klasifikasi sudah digunakan.',

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
        SubClassification::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.sub-classification.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(SubClassification $subClassification)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('sub_classification_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $subClassifications = SubClassification::find($id);
        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();

        return view('pages.master-data.classification.sub-classification.edit', compact('subClassifications', 'mainClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubClassification $subClassification)
    {
        if (! Gate::allows('sub_classification_update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            // 'code' => ['required', 'max:255',],

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
        if (! Gate::allows('sub_classification_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $subClassification = SubClassification::find($decrypt_id);

        // hapus location
        $subClassification->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
