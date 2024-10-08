<?php

namespace App\Http\Controllers\MasterData\Location;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Location\SubLocation;
use App\Models\MasterData\Location\MainLocation;

class SubLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('sub_location_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        if (Gate::allows('super_admin')) {
            $subLocations = SubLocation::with('mainLocation')->orderBy('name', 'asc')->get();
        } else {
            $subLocations = SubLocation::where('company_id', $company_id)->with('mainLocation')->orderBy('name', 'asc')->get();
        }

        return view('pages.master-data.location.sub-location.index', compact('subLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('sub_location_create')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.sub-location.create', compact('mainLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sub_location_store')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255',],
            // Add other validation rules as needed
        ], [
            'main_location_id.required' => 'Nama Lokasi Utama harus diisi.',
            'name.required' => 'Nama Sub Lokasi harus diisi.',
            'name.max' => 'Nama Sub Lokasi tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);

        SubLocation::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('sub-location.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(SubLocation $subLocation)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('sub_location_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $subLocations = SubLocation::find($id);
        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.sub-location.edit', compact('mainLocations', 'subLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubLocation $subLocation)
    {
        if (! Gate::allows('sub_location_update')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required', 'max:255',],
            'name' => ['required', 'max:255',],
            // Add other validation rules as needed
        ], [
            'main_location_id.required' => 'Nama Lokasi Utama harus diisi.',
            'name.required' => 'Nama Sub Lokasi harus diisi.',
            'name.max' => 'Nama Sub Lokasi tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $subLocation->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('sub-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('sub_location_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $subLocations = SubLocation::find($decrypt_id);

        // hapus location
        $subLocations->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
