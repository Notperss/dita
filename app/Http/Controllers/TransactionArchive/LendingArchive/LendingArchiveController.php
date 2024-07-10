<?php

namespace App\Http\Controllers\TransactionArchive\LendingArchive;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
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
    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $companies = auth()->user()->company_id;
        if (request()->ajax()) {

            if (Gate::allows('super_admin')) {
                $archiveContainers = ArchiveContainer::with('division')->where('status', 1);
            } else {
                $archiveContainers = ArchiveContainer::with('division')->where('company_id', $companies)->where('status', 1);
            }

            // Apply year filter if present
            if ($request->has('year') && ! empty($request->year)) {
                $archiveContainers->where('year', $request->year);
            }
            // Apply regarding filter if present
            if ($request->has('regarding') && ! empty($request->regarding)) {
                $archiveContainers->where('regarding', 'like', '%' . $request->regarding . '%');
            }
            // Apply catalog filter if present
            if ($request->has('catalog') && ! empty($request->catalog)) {
                $archiveContainers->where('number_catalog', 'like', '%' . $request->catalog . '%');
            }
            // Apply document filter if present
            if ($request->has('document') && ! empty($request->document)) {
                $archiveContainers->where('number_document', 'like', '%' . $request->document . '%');
            }
            // Apply archive filter if present
            if ($request->has('archive') && ! empty($request->archive)) {
                $archiveContainers->where('number_archive', 'like', '%' . $request->archive . '%');
            }
            // Apply tag filter if present
            if ($request->has('tag') && ! empty($request->tag)) {
                $archiveContainers->where('tag', 'like', '%' . $request->tag . '%');
            }
            // Apply type filter if present
            if ($request->has('type') && ! empty($request->type)) {
                $archiveContainers->where('archive_type', 'like', $request->type);
            }
            // Apply division filter if present
            if ($request->has('division') && ! empty($request->division)) {
                $archiveContainers->whereHas('division', function ($query) use ($request) {
                    $query->where('code', 'like', '%' . $request->division . '%');
                });
            }

            return DataTables::of($archiveContainers)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                <div class="buttons">
                    <button  class="btn btn-sm btn-success lend-btn" data-row-id="' . $item->id . '">Pinjam</button>
                </div>
                ';
                })
                ->rawColumns(['action',])
                ->toJson();
        }

        if (Gate::allows('super_admin')) {
            $lendings = Lending::where('status', null)->orderBy('created_at', 'desc')->get();
            $lendingArchives = LendingArchive::where('approval', 1)->where('status', 2)->get();

        } elseif (Gate::allows('admin')) {
            // $lendings = Lending::where('status', null)->where('company_id', $companies)->orderBy('created_at', 'desc')->get();
            $lendings = Lending::where('company_id', $companies)->orderBy('created_at', 'desc')->get();
            $lendingArchives = LendingArchive::where('approval', 1)->where('status', 2)->where('company_id', $companies)->orderBy('created_at', 'desc')->get();
        } else {
            $lendings = Lending::where('status', null)->where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $lendingArchives = LendingArchive::where('approval', 1)->where('status', 2)->where('status', 2)->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        }

        $newLendingNumber = Lending::generateLendingNumber();
        // $archiveContainers = ArchiveContainer::where('company_id', $companies)->where('status', 1)->orderBy('number_document', 'asc')->get();
        // $lendingArchives = LendingArchive::where('approval', 1)->get();
        $divisions = Division::orderBy('name', 'asc')->get();
        return view('pages.transaction-archive.lending-archive.index',
            compact(
                // 'archiveContainers',
                'divisions',
                'lendings',
                'newLendingNumber',
                'lendingArchives',
            ));
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
        // dd($request->all());
        // if (! Gate::allows('retention_store')) {
        //     abort(403);
        // }
        $validator = Validator::make($request->all(), [
            'lending_number' => ['required', Rule::unique('lendings'),],
            // 'division_id' => ['required'],
            // 'archive_container_id' => 'required|array', // Ensure archive_container_id is present and is an array
            // 'archive_container_id.*' => 'exists:lending_archives,id', // Validate each lending item ID exists in the database
            // Add more validation rules for other fields if necessary
            'inputs' => 'required|array',
            'inputs.*.document_type' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
            'inputs.*.archive_container_id' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID

            // Add other validation rules as needed
        ], [
            'lending_number.required' => 'Nomor Peminjaman harus diisi.',
            // 'division_id.required' => 'Divisi harus diisi.',
            // 'inputs' => 'Arsip tidak boleh kosong.',
            // 'inputs.*.archive_container_id.required' => 'Arsip tidak boleh kosong',
            // 'inputs.*.document_type.required' => 'Pilih setidaknya satu Tipe Dokumen',
            'lending_number.unique' => 'Nomor Peminjaman sudah digunakan.',


            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $division_id = Auth::user()->division_id;

        // Merge the user_id into the request data
        $requestData = array_merge($request->all(), [
            'user_id' => $user_id,
            'company_id' => $company_id,
            'division_id' => $division_id,
        ]
        );
        // If the validation passes, create the Divisi record
        $lending = Lending::create($requestData);
        $lending_id = $lending->id;

        if (! empty($request->inputs)) {
            foreach ($request->inputs as $value) {
                LendingArchive::create([
                    'user_id' => $user_id,
                    'company_id' => $company_id,
                    'division_id' => $division_id,
                    'lending_id' => $lending_id,
                    'archive_container_id' => $value['archive_container_id'],
                    'document_type' => $value['document_type'],
                    'status' => '1',
                ]);

                $archiveContainer = ArchiveContainer::find($value['archive_container_id']);
                $archiveContainer->update(['status' => 2]);
            }
        }
        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('lending-archive.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ids = auth()->user()->id;
        $company_id = auth()->user()->company_id;
        if (Gate::allows('super_admin')) {
            $lendings = Lending::find($id);

        } elseif (Gate::allows('admin')) {
            $lendings = Lending::where('company_id', $company_id)->find($id);
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
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lending $lending)
    {

        $validator = Validator::make($request->all(), [
            'lending_number' => [
                'required',
                Rule::unique('lendings')->ignore($lending->id),
            ],
            'division' => ['required'],
            'inputs' => 'required|array',
            'inputs.*.document_type' => 'required',
            'inputs.*.archive_container_id' => 'required',

            // Add other validation rules as needed
        ], [
            'lending_number.required' => 'Nomor Peminjaman harus diisi.',
            'division.required' => 'Divisi harus diisi.',
            'inputs' => 'Arsip tidak boleh kosong.',
            'inputs.*.archive_container_id.required' => 'Arsip tidak boleh kosong',
            'inputs.*.document_type.required' => 'Pilih setidaknya satu Tipe Dokumen',
            'lending_number.unique' => 'Nomor Peminjaman sudah digunakan.', // Pesan khusus untuk aturan validasi unique

            // Add custom error messages for other rules
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lending = Lending::findOrFail($id);

        $lendingArchives = $lending->lendingArchive;
        foreach ($lendingArchives as $lendingArchive) {
            $idContainer = $lendingArchive->archive_container_id;
            $archiveStatus = ArchiveContainer::find($idContainer);
            $archiveStatus->update(['status' => 1]);
        }

        $lending->forceDelete();

        // Delete associated LendingArchive records
        LendingArchive::where('lending_id', $id)->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    // get show_file software
    public function show_file(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $lending_archive = LendingArchive::with('lending')->where('lending_id', $id)->get();
            $row = Lending::find($id);
            // $row = LendingArchive::find($id);

            $data = [
                'lending_archives' => $lending_archive,
                'id' => $row,

            ];

            $msg = [
                'data' => view('pages.transaction-archive.lending-archive.detail-lending-archive', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    public function approval(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'approval' => 'required|array|min:1', // Ensure 'approval' is present, is an array, and has at least one element
        //     'approval.*' => 'required', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
        //     // 'approval.*' => 'required|exists:lendings,id', // Ensure each 'approval' item corresponds to an existing 'lendings' ID
        // ], [
        //     'approval.required' => 'Persetujuan tidak boleh kosong',
        //     'approval.min' => 'Pilih setidaknya satu persetujuan',
        //     'approval.*.required' => 'Pilih setidaknya satu persetujuan',
        //     // 'approval.*.exists' => 'Pilihan persetujuan tidak valid',
        // ]);

        // // Check if validation fails
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // Get the IDs from the request
        $id = $request->input('id');

        // Convert the ID to an array if it's not already an array
        $approvedIds = is_array($id) ? $id : [$id];

        // Get the current date plus 14 days
        // $period = Carbon::now()->addDays(7)->toDateString();
        // $periodDigital = Carbon::now()->addDays(3)->toDateString();

        // Get the approval values from the request
        $approvals = $request->input('approval');

        // Update the LendingArchive records for each approval value
        foreach ($approvedIds as $approvedId) {
            $approval = isset($approvals[$approvedId]);

            // Fetch the LendingArchive record
            $lendingArchive = LendingArchive::find($approvedId);

            if ($lendingArchive) {
                // Determine the period based on the document type
                $period = $lendingArchive->document_type === 'DIGITAL'
                    ? Carbon::now()->addDays(3)->toDateString()
                    : Carbon::now()->addDays(7)->toDateString();

                LendingArchive::where('id', $approvedId)->update([
                    'period' => $approval ? $period : null,
                    'status' => $approval ? 2 : 1,
                    'approval' => $approval,
                ]);
            }
        }


        // // Get the IDs of the lending archive records where the checkbox is not checked
        // $notApprovedIds = array_diff(
        //     LendingArchive::pluck('id')->all(),
        //     $approvedIds
        // );

        // // Update the lending archive records where the checkbox is not checked
        // LendingArchive::whereIn('id', $notApprovedIds)->update([
        //     'status' => 2,  // Assuming status always needs to be updated
        //     'approval' => 0,  // Set to 0 if the checkbox is not checked
        // ]);

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
        return redirect()->route('lending-archive.index');
    }

    public function closing($id)
    {
        $lending = Lending::find($id);

        if ($lending) {
            // Update the lending record
            $lending->update([
                'status' => 1,  // Set to 1 if the checkbox is not checked
                'end_date' => now()->toDateString(),  // Set to 1 if the checkbox is not checked
            ]);
        }

        $lendingArchives = $lending->lendingArchive;

        if ($lendingArchives->isNotEmpty()) {
            // Initialize an array to store archive container IDs
            $archiveIds = [];

            // Loop through each lending archive
            foreach ($lendingArchives as $lendingArchive) {
                $lendingArchive->update(['status' => 3]);

                // Check if the archive container relationship exists
                if ($archiveContainer = $lendingArchive->archiveContainer) {
                    // Store the archive container ID
                    $archiveIds[] = $archiveContainer->id;
                }
            }

            // Update the status for each archive container
            foreach ($archiveIds as $archiveId) {
                $archiveContainer = ArchiveContainer::find($archiveId);

                if ($archiveContainer) {
                    $archiveContainer->update(['status' => 1]);
                }
            }
        }
        alert()->success('Success', 'Data updated successfully.');
        return redirect()->back();
    }

    public function historyDetail($id)
    {
        // $ids = auth()->user();
        // if (Gate::allows('super_admin')) {
        //     $lendingArchives = LendingArchive::find($id);
        // } elseif (Gate::allows('admin')) {
        //     $lendingArchives = LendingArchive::where('company_id', $ids->company_id)->find($id);
        // } else {
        //     $lendingArchives = LendingArchive::where('user_id', $ids->id)->find($id);
        // }
        $ids = auth()->user();
        if (Gate::allows('super_admin')) {
            $lendingArchives = LendingArchive::find($id);
        } else {
            $lendingArchives = LendingArchive::where('user_id', $ids->id)->find($id);
        }
        return view('pages.transaction-archive.lending-archive.historyDetail', compact('lendingArchives'));
    }

    public function history()
    {
        $id = auth()->user();
        if (Gate::allows('super_admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->orderBy('created_at', 'desc')->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->where('company_id', $id->company_id)->orderBy('created_at', 'desc')->get();
        } else {
            $lendingArchives = LendingArchive::where('status', 3)->where('user_id', $id->id)->orderBy('created_at', 'desc')->get();
        }

        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }

    public function fisik()
    {
        $id = auth()->user();
        if (Gate::allows('super_admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'FISIK')->orderBy('created_at', 'desc')->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'FISIK')->where('company_id', $id->company_id)->orderBy('created_at', 'desc')->get();
        } else {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'FISIK')->where('user_id', $id->id)->orderBy('created_at', 'desc')->get();
        }
        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }
    public function digital()
    {
        $id = auth()->user();
        if (Gate::allows('super_admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'DIGITAL')->orderBy('created_at', 'desc')->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'DIGITAL')->where('company_id', $id->company_id)->orderBy('created_at', 'desc')->get();
        } else {
            $lendingArchives = LendingArchive::where('status', 3)->where('document_type', 'DIGITAL')->where('user_id', $id->id)->orderBy('created_at', 'desc')->get();
        }
        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }

    // public function addWatermark(Request $request)
    // {
    //     $filePath = public_path($request->file_path);

    //     // Load PDF content
    //     $pdf = PDF::loadFile($filePath);

    //     // Add watermark to PDF
    //     $pdf->getDomPDF()->getCanvas()->page_text(250, 400, "Watermark Text", null, 12, array(128, 128, 128));

    //     // Save watermarked PDF to a temporary file
    //     $tempFilePath = tempnam(sys_get_temp_dir(), 'watermarked_pdf_');
    //     $pdf->save($tempFilePath);

    //     return response()->json($tempFilePath);
    // }
}