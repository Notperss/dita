<?php

namespace App\Http\Controllers\TransactionArchive\LendingArchive;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
                $archiveContainers = ArchiveContainer::with('division')->where('archive_status', 'baik')->where('is_lend', false);
            } else {
                $archiveContainers = ArchiveContainer::with('division')->where('company_id', $companies)->where('is_lend', false)->where('archive_status', 'baik');
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


        $queryLending = Lending::orderBy('created_at', 'desc');
        $queryLendArchive = LendingArchive::where('is_approve', true)->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $lendings = $queryLending->get();
            $lendingArchives = $queryLendArchive->get();
        } elseif (Gate::allows('admin')) {
            $lendings = $queryLending->where('company_id', $companies)->get();
            $lendingArchives = $queryLendArchive->where('company_id', $companies)->get();
        } else {
            $lendings = $queryLending->where('user_id', $id)->get();
            $lendingArchives = $queryLendArchive->where('user_id', $id)->get();
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
                    // 'status' => '1',
                ]);

                $archiveContainer = ArchiveContainer::find($value['archive_container_id']);
                $archiveContainer->update(['status' => 2, 'is_lend' => true]);
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
        return abort(403);
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
            $archiveStatus->update(['status' => 1, 'is_lend' => false]);
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
        // Get the IDs from the request
        $id = $request->input('id');

        // Convert the ID to an array if it's not already an array
        $approvedIds = is_array($id) ? $id : [$id];

        // Get the approval values from the request
        $approvals = $request->input('approval');
        $damagedStatuses = $request->input('damage_status');
        $files = $request->file('files');


        // Update the LendingArchive records for each approval value
        foreach ($approvedIds as $approvedId) {

            $approval = isset($approvals[$approvedId]);
            $damagedStatus = isset($damagedStatuses[$approvedId]) ? $damagedStatuses[$approvedId] : null;

            // Fetch the LendingArchive record
            $lendingArchive = LendingArchive::find($approvedId);

            $path_file = $lendingArchive['file'];
            // Handle file upload if a file is provided
            if (isset($files[$approvedId])) {
                $file = $files[$approvedId];
                // Save the file to storage/app/public/uploads directory
                $filePath = $file->storeAs('file-kerusakan-arsip', time() . '-' . Str::random(2) . '-' . $file->getClientOriginalName(), 'nas');

                // You can store the file path or name in the database if needed
                $lendingArchive->file_path = $filePath; // Assuming you have a column for storing file paths

                // hapus file
                if ($path_file != null || $path_file != '') {
                    Storage::disk('nas')->delete($path_file);
                }
            }

            if ($lendingArchive) {
                // Determine the period based on the document type
                $period = $lendingArchive->document_type === 'DIGITAL'
                    ? Carbon::now()->addDays(3)->toDateString()
                    : Carbon::now()->addDays(7)->toDateString();

                LendingArchive::where('id', $approvedId)->update([
                    'period' => $approval ? $period : null,
                    'is_approve' => $approval,
                    'damage_status' => $damagedStatus !== null ? $damagedStatus : $lendingArchive->damaged_status,
                    'file' => $lendingArchive->file_path,
                ]);

                // dd($approvedId->archiveContainer->id);
                $archiveContainer = $lendingArchive->archiveContainer;
                $archiveContainer->update(['archive_status' => $damagedStatus !== null ? $damagedStatus : $lendingArchive->damaged_status]);

            }
        }

        alert()->success('Success', 'Data updated successfully.');
        return redirect()->route('lending-archive.index');
    }

    public function closing($id)
    {
        $lending = Lending::find($id);

        if ($lending) {
            // Update the lending record
            $lending->update([
                // 'status' => 1,  // Set to 1 if the checkbox is not checked
                'has_finished' => true,  // Set to 1 if the checkbox is not checked
                'end_date' => now()->toDateString(),  // Set to 1 if the checkbox is not checked
            ]);
        }

        $lendingArchives = $lending->lendingArchive;

        if ($lendingArchives->isNotEmpty()) {
            // Initialize an array to store archive container IDs
            $archiveIds = [];

            // Loop through each lending archive
            foreach ($lendingArchives as $lendingArchive) {
                $lendingArchive->update(['has_finished' => true]);

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
                    $archiveContainer->update(['status' => 1, 'is_lend' => false]);
                }
            }
        }
        alert()->success('Success', 'Data updated successfully.');
        return redirect()->back();
    }

    public function historyDetail($id)
    {
        $user = auth()->user();
        if (Gate::allows('super_admin')) {
            $lendingArchives = LendingArchive::find($id);
        } elseif (Gate::allows('admin')) {
            $lendingArchives = LendingArchive::where('company_id', $user->company_id)->find($id);
        } else {
            $lendingArchives = LendingArchive::where('user_id', $user->id)->find($id);
        }
        return view('pages.transaction-archive.lending-archive.historyDetail', compact('lendingArchives'));
    }

    public function history()
    {
        $user = auth()->user();
        $queryLendArchive = LendingArchive::where('has_finished', true)->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $lendingArchives = $queryLendArchive->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = $queryLendArchive->where('company_id', $user->company_id)->get();
        } else {
            $lendingArchives = $queryLendArchive->where('user_id', $user->id)->get();
        }

        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }

    public function fisik()
    {
        $user = auth()->user();
        $queryLendArchive = LendingArchive::where('has_finished', true)->where('document_type', 'FISIK')->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $lendingArchives = $queryLendArchive->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = $queryLendArchive->where('company_id', $user->company_id)->get();
        } else {
            $lendingArchives = $queryLendArchive->where('user_id', $user->id)->get();
        }
        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }
    public function digital()
    {
        $user = auth()->user();
        $queryLendArchive = LendingArchive::where('has_finished', true)->where('document_type', 'DIGITAL')->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $lendingArchives = $queryLendArchive->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = $queryLendArchive->where('company_id', $user->company_id)->get();
        } else {
            $lendingArchives = $queryLendArchive->where('user_id', $user->id)->get();
        }
        return view('pages.transaction-archive.lending-archive.history', compact('lendingArchives', ));
    }
    public function rejected()
    {
        $user = auth()->user();
        $queryLendArchive = LendingArchive::where('has_finished', true)->where('is_approve', false)->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $lendingArchives = $queryLendArchive->get();
        } elseif (Gate::allows('admin')) {
            $lendingArchives = $queryLendArchive->where('company_id', $user->company_id)->get();
        } else {
            $lendingArchives = $queryLendArchive->where('user_id', $user->id)->get();
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