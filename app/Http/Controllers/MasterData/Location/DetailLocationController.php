<?php

namespace App\Http\Controllers\MasterData\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Location\SubLocation;
use App\Models\MasterData\Location\MainLocation;
use App\Models\MasterData\Location\DetailLocation;

class DetailLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('detail_location_index')) {
            abort(403);
        }

        $company_id = auth()->user()->company_id;
        $detailLocations = DetailLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        // $detailLocations = DetailLocation::with('mainLocation', 'subLocation')->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.detail-location.index', compact('detailLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('detail_location_create')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $subLocations = SubLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.detail-location.create', compact('mainLocations', 'subLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('detail_location_store')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required', 'max:255'],
            'sub_location_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255',],
            'description' => ['max:255',],
            // Add other validation rules as needed
        ], [
            'main_location_id.required' => 'Nama Lokasi Utama harus diisi.',
            'sub_location_id.required' => 'Nama Sub Lokasi harus diisi.',
            'name.required' => 'Nama Detail Lokasi harus diisi.',
            'name.max' => 'Nama Detail Lokasi tidak boleh lebih dari :max karakter.',
            'description.max' => 'Keterangan tidak boleh lebih dari :max karakter.',
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
        DetailLocation::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.detail-location.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(DetailLocation $detailLocation)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('detail_location_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $detailLocations = DetailLocation::find($id);
        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $subLocations = SubLocation::where('main_location_id', $detailLocations->main_location_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.detail-location.edit', compact('mainLocations', 'subLocations', 'detailLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailLocation $detailLocation)
    {
        if (! Gate::allows('detail_location_update')) {
            abort(403);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required', 'max:255'],
            'sub_location_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255',],
            'description' => ['max:255',],
            // Add other validation rules as needed
        ], [
            'main_location_id.required' => 'Nama Lokasi Utama harus diisi.',
            'sub_location_id.required' => 'Nama Sub Lokasi harus diisi.',
            'name.required' => 'Nama Detail Lokasi harus diisi.',
            'name.max' => 'Nama Detail Lokasi tidak boleh lebih dari :max karakter.',
            'description.max' => 'Keterangan tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $detailLocation->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.detail-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('detail_location_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $detailLocations = DetailLocation::find($decrypt_id);

        // dd($detailLocations);
        // hapus location
        $detailLocations->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function getSubLocations(Request $request)
    {
        $mainLocationId = $request->input('main_location_id');
        $subLocations = SubLocation::where('main_location_id', $mainLocationId)->get();
        return response()->json($subLocations);
    }
    public function getContainers(Request $request)
    {
        $subLocationId = $request->input('sub_location_id');
        $detailLocations = DetailLocation::where('sub_location_id', $subLocationId)->get();
        return response()->json($detailLocations);
    }


}
