<?php

namespace App\Http\Controllers\MasterData\Retention;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Retention\RetentionArchives;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\MasterData\Classification\MainClassification;

class RetentionArchivesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('retention_index')) {
            abort(403);
        }
        $retentions = RetentionArchives::orderBy('sub_series', 'asc')->get();
        $subClassifications = SubClassification::orderBy('name', 'asc')->get();
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        return view('pages.master-data.retention.index', compact('subClassifications', 'mainClassifications', 'retentions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('retention_create')) {
            abort(403);
        }
        $subClassifications = SubClassification::orderBy('name', 'asc')->get();
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        return view('pages.master-data.retention.create', compact('subClassifications', 'mainClassifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('retention_store')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'main_classification_id' => ['required'],
            'sub_classification_id' => ['required'],
            // 'sub_series' => ['required', 'max:255', Rule::unique('retention_archives')],
            'sub_series' => ['required', 'max:255'],
            'period_active' => ['required',],
            'period_inactive' => ['required',],


            // Add other validation rules as needed
        ], [
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'sub_classification_id.required' => 'Nama Sub Klasifikasi harus diisi.',
            'sub_series.required' => 'Sub Series harus diisi.',
            'period_active.required' => 'Masa Aktif harus diisi.',
            'period_inactive.required' => 'Masa Inaktif harus diisi.',
            'sub_series.max' => 'Sub Series tidak boleh lebih dari :max karakter.',
            // 'sub_series.unique' => 'Sub Series sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        RetentionArchives::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.retention.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(RetentionArchives $retentionArchives)
    {
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('retention_edit')) {
            abort(403);
        }
        $retentions = RetentionArchives::find($id);
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('main_classification_id', $retentions->main_classification_id)->orderBy('name', 'asc')->get();

        return view('pages.master-data.retention.edit', compact('retentions', 'mainClassifications', 'subClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RetentionArchives $retention)
    {
        if (! Gate::allows('retention_update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'main_classification_id' => ['required'],
            'sub_classification_id' => ['required'],
            // 'sub_series' => ['required', 'max:255', Rule::unique('retention_archives')->ignore($retention->id)],
            'sub_series' => ['required', 'max:255'],
            'period_active' => ['required',],
            'period_inactive' => ['required',],


            // Add other validation rules as needed
        ], [
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'sub_classification_id.required' => 'Nama Sub Klasifikasi harus diisi.',
            'sub_series.required' => 'Sub Series harus diisi.',
            'period_active.required' => 'Masa Aktif harus diisi.',
            'period_inactive.required' => 'Masa Inaktif harus diisi.',
            'sub_series.max' => 'Sub Series tidak boleh lebih dari :max karakter.',
            // 'sub_series.unique' => 'Sub Series sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $retention->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.retention.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('retention_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $retentionArchives = RetentionArchives::find($decrypt_id);

        // hapus location
        $retentionArchives->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function getSubClassifications(Request $request)
    {
        $mainClassification = $request->input('main_classification_id');
        $subClassifications = SubClassification::where('main_classification_id', $mainClassification)->get();
        return response()->json($subClassifications);
    }
    public function getSeriesClassifications(Request $request)
    {
        $subClassification = $request->input('sub_classification_id');
        $seriesClassifications = RetentionArchives::where('sub_classification_id', $subClassification)->get();
        return response()->json($seriesClassifications);
    }
}
