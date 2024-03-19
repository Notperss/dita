<?php

namespace App\Http\Controllers\MasterData\Location;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\MasterData\Location\SubLocation;
use App\Models\MasterData\Location\MainLocation;
use App\Models\MasterData\Location\DetailLocation;
use App\Models\MasterData\Location\ContainerLocation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ContainerLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('container_location_index')) {
            abort(403);
        }
        // $company_id = auth()->user()->company_id;
        // $containerLocations = ContainerLocation::
        //     where('company_id', $company_id)->
        //     with('mainLocation',
        //         'subLocation',
        //         'detailLocation')
        //     ->orderBy('number_container', 'asc')
        //     ->get();


        if (request()->ajax()) {

            $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user

            $containerLocations = ContainerLocation::
                where('location_containers.company_id', $company_id)->
                with('mainLocation',
                    'subLocation',
                    'detailLocation',
                    'division')
                ->orderBy('number_container', 'desc');

            return DataTables::of($containerLocations)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                    <a href="#mymodal" data-remote="' . route('backsite.showBarcode', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="Detail Data" class="btn icon btn-info">
                        <i class="bi bi-qr-code-scan"></i>
                    </a>

                <div class="btn-group mb-1">

                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="#mymodal" data-remote="' . route('backsite.container-location.show', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                        Show
                    </a>
                        <a class="dropdown-item"
                        href="' . route('backsite.container-location.edit', $item->id) . '">Edit</a>
                    <a class="dropdown-item" onclick="showSweetAlert(' . $item->id . ')">Delete</a>
                </div>
                    </div>
                </div>
                <form id="deleteForm_' . $item->id . '"
                    action="' . route('backsite.container-location.destroy', encrypt($item->id)) . '"
                    method="POST">
                    ' . method_field('delete') . csrf_field() . '
                </form>
                ';
                })
                ->editColumn('number_container', function ($item) {
                    return isset ($item->number_container) ? str_pad($item->number_container, 3, '0', STR_PAD_LEFT) : 'N/A';
                })
                ->filterColumn('number_container', function ($query, $keyword) {
                    // Use a where clause to search for 'number_container' column
                    $query->whereRaw("LPAD(number_container, 3, '0') LIKE ?", ["%$keyword%"]);
                })
                ->editColumn('main_location_id', function ($item) {
                    return $item->mainLocation->name;
                })
                ->filterColumn('main_location_id', function ($query, $keyword) {
                    // Use a where clause to search for 'name' column in 'mainLocation' relationship
                    $query->whereHas('mainLocation', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->editColumn('sub_location_id', function ($item) {
                    return $item->subLocation->name;
                })
                ->filterColumn('sub_location_id', function ($query, $keyword) {
                    // Use a where clause to search for 'name' column in 'mainLocation' relationship
                    $query->whereHas('subLocation', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->editColumn('detail_location_id', function ($item) {
                    return $item->detailLocation->name;
                })
                ->filterColumn('detail_location_id', function ($query, $keyword) {
                    // Use a where clause to search for 'name' column in 'mainLocation' relationship
                    $query->whereHas('detailLocation', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->rawColumns(['action',])
                ->toJson();
        }

        return view('pages.master-data.location.container.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('container_location_create')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $latestReport = DB::table('location_containers')
            ->where('company_id', $company_id)
            ->whereNotNull('number_container')
            ->latest()
            ->first();

        // Determine the next number for the container within the current company
        $nextNumber = $latestReport ? $latestReport->number_container + 1 : 1;

        // Format the next number with leading zeros
        $formattedNextNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $divisions = Division::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.container.create', compact('mainLocations', 'divisions', 'formattedNextNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('container_location_store')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required'],
            'sub_location_id' => ['required'],
            'detail_location_id' => ['required'],
            'division_id' => ['required'],
            // 'number_container' => ['required', Rule::unique('location_containers')],
            // Add other validation rules as needed
        ],
            [
                'main_location_id.required' => 'Lokasi Utama harus diisi.',
                'sub_location_id.required' => 'Sub Lokasi harus diisi.',
                'detail_location_id.required' => 'Detail Lokasi harus diisi.',
                'division_id.required' => 'Divisi harus diisi.',
                'number_container.required' => 'Nomor Container harus diisi.',
                // Add custom error messages for other rules
            ]
        );
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        // If the validation passes, create the MainLocation record
        ContainerLocation::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.container-location.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $containerLocation = ContainerLocation::find($id);

        // $filepath = storage_path($containerLocation->file);
        // $fileName = basename($filepath);
        return view('pages.master-data.location.container.show',
            compact(
                'containerLocation',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('container_location_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $containerLocations = ContainerLocation::find($id);
        $divisions = Division::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $mainLocations = MainLocation::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $subLocations = SubLocation::where('main_location_id', $containerLocations->main_location_id)->orderBy('name', 'asc')->get();
        $detailLocations = DetailLocation::where('sub_location_id', $containerLocations->sub_location_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.location.container.edit', compact('mainLocations', 'subLocations', 'detailLocations', 'containerLocations', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContainerLocation $containerLocation)
    {
        if (! Gate::allows('container_location_update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'main_location_id' => ['required'],
            'sub_location_id' => ['required'],
            'detail_location_id' => ['required'],
            'division_id' => ['required'],
            'number_container' => ['required', Rule::unique('location_containers')->ignore($containerLocation->id)],
            // Add other validation rules as needed
        ],
            [
                'main_location_id.required' => 'Lokasi Utama harus diisi.',
                'sub_location_id.required' => 'Sub Lokasi harus diisi.',
                'detail_location_id.required' => 'Detail Lokasi harus diisi.',
                'division_id.required' => 'Divisi harus diisi.',
                'number_container.required' => 'Nomor Container harus diisi.',
                // Add custom error messages for other rules
            ]
        );
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
        if (! Gate::allows('container_location_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $containerLocations = ContainerLocation::find($decrypt_id);

        // dd($containerLocations);
        // hapus location
        $containerLocations->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function showBarcode($id)
    {

        // $decrypt_id = decrypt($id);
        // $barang = Barang::find($decrypt_id);
        $location_container = ContainerLocation::find($id);
        $qr = QrCode::size(170)->style('round')->margin(1)->generate(route('show-qr', $id));
        return view('components.qr-code.show-barcode', compact('location_container', 'qr'));
    }
}
