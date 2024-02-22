<?php

namespace App\Http\Controllers\MasterData\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Location\SubLocation;
use App\Models\MasterData\Location\MainLocation;
use App\Models\MasterData\Location\DetailLocation;
use App\Models\MasterData\Location\ContainerLocation;

class ContainerLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $containerLocations = ContainerLocation::
            with('mainLocation',
                'subLocation',
                'detailLocation')
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.master-data.location.container.index', compact('containerLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainLocations = MainLocation::orderBy('name', 'asc')->get();
        return view('pages.master-data.location.container.create', compact('mainLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required', 'max:255'],
            'sub_location_id' => ['required', 'max:255'],
            'detail_location_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255',],
            'description' => ['max:255',],
            // Add other validation rules as needed
        ],
            [
                'main_location_id.required' => 'Nama Lokasi Utama harus diisi.',
                'sub_location_id.required' => 'Nama Sub Lokasi harus diisi.',
                'detail_location_id.required' => 'Nama Detail Lokasi harus diisi.',
                'name.required' => 'Nama Container Lokasi harus diisi.',
                'name.max' => 'Nama Container Lokasi tidak boleh lebih dari :max karakter.',
                'description.max' => 'Keterangan tidak boleh lebih dari :max karakter.',
                // Add custom error messages for other rules
            ]
        );
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the MainLocation record
        ContainerLocation::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.container-location.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContainerLocation $containerLocation)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $containerLocations = ContainerLocation::find($id);
        $mainLocations = MainLocation::orderBy('name', 'asc')->get();
        $subLocations = SubLocation::where('main_location_id', $containerLocations->main_location_id)->orderBy('name', 'asc')->get();
        $detailLocations = DetailLocation::where('sub_location_id', $containerLocations->sub_location_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.container.edit', compact('mainLocations', 'subLocations', 'detailLocations', 'containerLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContainerLocation $containerLocation)
    {
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

        $containerLocation->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.container-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        $decrypt_id = decrypt($id);
        $containerLocations = ContainerLocation::find($decrypt_id);

        // dd($containerLocations);
        // hapus location
        $containerLocations->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
