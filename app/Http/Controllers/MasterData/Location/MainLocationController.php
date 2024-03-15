<?php

namespace App\Http\Controllers\MasterData\Location;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Location\MainLocation;

class MainLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If user is not authorized, abort
        if (! Gate::allows('main_location_index')) {
            abort(403);
        }

        $mainLocations = MainLocation::orderBy('name', 'asc')->get();
        return view('pages.master-data.location.main-location.index', compact('mainLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('main_location_create')) {
            abort(403);
        }
        return view('pages.master-data.location.main-location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('main_location_store')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('location_mains')],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Lokasi Utama harus diisi.',
            'name.max' => 'Nama Lokasi Utama tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama Lokasi Utama sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the MainLocation record
        MainLocation::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.main-location.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MainLocation $mainLocation)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('main_location_edit')) {
            abort(403);
        }
        $mainLocations = MainLocation::find($id);
        // $locations = MainLocation::orderBy('name', 'asc')->get();
        return view('pages.master-data.location.main-location.edit', compact('mainLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainLocation $mainLocation)
    {
        if (! Gate::allows('main_location_update')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('location_mains')->ignore($mainLocation->id)],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Lokasi Utama harus diisi.',
            'name.max' => 'Nama Lokasi Utama tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama Lokasi Utama sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $mainLocation->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.main-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('main_location_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $locations = MainLocation::find($decrypt_id);

        // hapus location
        $locations->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
