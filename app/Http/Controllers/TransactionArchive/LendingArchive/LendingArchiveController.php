<?php

namespace App\Http\Controllers\TransactionArchive\LendingArchive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\LendingArchive\Lending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;

class LendingArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->user()->id;
        $archiveContainers = ArchiveContainer::orderBy('number_archive', 'asc')->get();
        $divisions = Division::orderBy('name', 'asc')->get();
        $lendings = Lending::where('user_id', $id)->orderBy('created_at', 'asc')->get();
        return view('pages.transaction-archive.lending-archive.index', compact('archiveContainers', 'divisions', 'lendings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (! Gate::allows('retention_store')) {
        //     abort(403);
        // }
        $validator = Validator::make($request->all(), [
            'lending_number' => ['required'],
            'division' => ['required'],
            // Add other validation rules as needed
        ], [
            'lending_number.required' => 'Nomor Peminjaman harus diisi.',
            'division.required' => 'Divisi harus diisi.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = Auth::user()->id;

        // Merge the user_id into the request data
        $requestData = array_merge($request->all(), ['user_id' => $user_id]);
        // If the validation passes, create the Divisi record
        $lending = Lending::create($requestData);
        $lending_id = $lending->id;

        if (! empty ($request->inputs)) {
            foreach ($request->inputs as $value) {
                LendingArchive::create([
                    'lending_id' => $lending_id,
                    'archive_container_id' => $value['archive_container_id'],
                    'status' => '1',
                    // 'internet_access' => $value['internet_access'],
                    // 'gateway' => $value['gateway'],
                ]);
            }
        }

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.lending-archive.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ids = auth()->user()->id;
        $lendings = Lending::where('user_id', $ids)->find($id);
        return view('pages.transaction-archive.lending-archive.show', compact('lendings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LendingArchive $lendingArchive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LendingArchive $lendingArchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LendingArchive $lendingArchive)
    {
        //
    }

    // get show_file software
    public function show_file(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $lending_archive = LendingArchive::where('lending_id', $id)->get();
            $data = [
                'lending_archives' => $lending_archive,
            ];

            $msg = [
                'data' => view('pages.transaction-archive.lending-archive.detail-lending-archive', $data)->render(),
            ];

            return response()->json($msg);
        }
    }
}
