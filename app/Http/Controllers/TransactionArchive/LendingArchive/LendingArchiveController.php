<?php

namespace App\Http\Controllers\TransactionArchive\LendingArchive;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\LendingArchive\Lending;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;

class LendingArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->user()->id;
        if (Gate::allows('super_admin')) {
            $lendings = Lending::orderBy('created_at', 'asc')->get();
        } else {

            $lendings = Lending::where('user_id', $id)->orderBy('created_at', 'asc')->get();
        }
        $archiveContainers = ArchiveContainer::orderBy('number_archive', 'asc')->get();
        $divisions = Division::orderBy('name', 'asc')->get();
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
            'inputs' => 'required|array',
            'inputs.*.type_document' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
            'inputs.*.archive_container_id' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID

            // Add other validation rules as needed
        ], [
            'lending_number.required' => 'Nomor Peminjaman harus diisi.',
            'division.required' => 'Divisi harus diisi.',
            'inputs' => 'Arsip tidak boleh kosong.',
            'inputs.*.archive_container_id.required' => 'Arsip tidak boleh kosong',
            'inputs.*.type_document.required' => 'Pilih setidaknya satu Tipe Dokumen',


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
                    'user_id' => $user_id,
                    'lending_id' => $lending_id,
                    'archive_container_id' => $value['archive_container_id'],
                    'type_document' => $value['type_document'],
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
        if (Gate::allows('super_admin')) {
            $lendings = Lending::find($id);
        } else {
            $lendings = Lending::where('user_id', $ids)->find($id);
        }
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

    public function approval(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'approval' => 'required|array|min:1', // Ensure 'approval' is present, is an array, and has at least one element
            'approval.*' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
            // 'approval.*' => 'required|exists:lendings,id', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
        ], [
            'approval.required' => 'Persetujuan tidak boleh kosong',
            'approval.min' => 'Pilih setidaknya satu persetujuan',
            'approval.*.required' => 'Pilih setidaknya satu persetujuan',
            // 'approval.*.exists' => 'Pilihan persetujuan tidak valid',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the IDs of the lending archive records to be updated
        $approvedIds = $request->input('approval');

        $period = Carbon::now()->addDays(14)->toDateString();

        // Update the lending archive records with the approved IDs
        LendingArchive::whereIn('id', $approvedIds)->update([
            'period' => DB::raw('CASE WHEN approval = 1 THEN NULL ELSE "' . $period . '" END'),
            'status' => DB::raw('CASE WHEN approval = 1 THEN 1 ELSE 2 END'),  // Assuming status always needs to be updated
            'approval' => DB::raw('CASE WHEN approval = 1 THEN 0 ELSE 1 END'),  // Set to 1 by default
        ]);

        // Get the IDs of the lending archive records where the checkbox is not checked
        $notApprovedIds = array_diff(
            LendingArchive::pluck('id')->all(),
            $approvedIds
        );

        // Update the lending archive records where the checkbox is not checked
        LendingArchive::whereIn('id', $notApprovedIds)->update([
            'status' => 2,  // Assuming status always needs to be updated
            'approval' => 0,  // Set to 0 if the checkbox is not checked
        ]);

        // // Grant access to view the archive if approved and within the permit period
        // $approvedArchives = LendingArchive::whereIn('id', $approvedIds)->where('approval', 1)->get();

        // foreach ($approvedArchives as $archive) {
        //     $user_id = $archive->user_id;
        //     $user = User::find($user_id);

        //     if (! $user) {
        //         continue; // Skip to the next iteration if user not found
        //     }

        //     // Assuming the period is specified in days
        //     $expiryDate = Carbon::parse($archive->period)->addDays(1); // Add one day to ensure expiry at end of day
        //     $now = Carbon::now();

        //     if ($now->lte($expiryDate)) {
        //         // Grant access if current time is less than or equal to the expiry date
        //         $user->givePermissionTo('view_archive');
        //     } else {
        //         // Revoke access if the expiry date has passed
        //         $user->revokePermissionTo('view_archive');
        //     }
        // }





        alert()->success('Success', 'Data updated successfully.');
        return redirect()->route('backsite.lending-archive.index');
    }
}
