<?php

namespace App\Http\Controllers\TransactionArchive\DestructionArchive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\DestructionArchive\DestructionArchive;

class DestructionArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $division_id = auth()->user()->division_id;
        $company_id = auth()->user()->company_id;

        $archivesQuery = ArchiveContainer::with('division')->whereDate('expiration_inactive', '<', now()->toDateString())->orderBy('created_at', 'desc');
        $divisionsQuery = Division::with('archive_container')->orderBy('code', 'asc');

        // Filter archives and divisions based on user role
        if (Gate::allows('super_admin')) {
            $archives = $archivesQuery->get();
            $divisions = $divisionsQuery->get();
        } elseif (Gate::allows('admin')) {
            $archives = $archivesQuery->where('company_id', $company_id)->get();
            $divisions = $divisionsQuery->where('company_id', $company_id)->get();
        } else {
            $archives = $archivesQuery->where('archive_status', 'baik')->where('company_id', $company_id)->where('division_id', $division_id)->get();
            $divisions = $divisionsQuery->where('company_id', $company_id)->where('id', $division_id)->get();
        }
        if (request()->ajax()) {
            return DataTables::of($archives)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $html = '';

                    if (Gate::allows('user')) {
                        $html .= '
                <li class="d-inline-block me-2 mb-1">
                    <div class="form-check">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-check-input form-check-danger"
                                   name="approval[' . $item->id . ']" id="customColorCheck' . $item->id . '">
                            <label class="form-check-label" for="customColorCheck' . $item->id . '">
                               Musnahkan
                            </label>
                        </div>
                    </div>
                </li>';
                    } else {
                        if ($item->archive_status == 'musnah') {
                            $html .= '<span style="color: red">Dimusnahkan</span>';
                        }
                    }

                    return $html;
                })
                ->editColumn('division.name', function ($item) {
                    return $item->division->name;
                })
                // ->editColumn('regarding', function ($item) {
                //     // Render the view content and store it in a variable
                //     // $content = view('pages.transaction-archive.destruction-archive.content-show', compact('item'))->render();

                //     // Store the modal content in a variable to include later
                //     $modal = '
                // <div class="modal fade" id="modal-content-' . $item->id . '" tabindex="-1" aria-labelledby="modalLabel-' . $item->id . '" aria-hidden="true">
                //     <div class="modal-dialog modal-lg">
                //         <div class="modal-content">
                //             <div class="modal-header">
                //                 <h5 class="modal-title" id="modalLabel-' . $item->id . '">Item Details</h5>
                //                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                //             </div>
                //             <div class="modal-header">
                //                 <h5 class="modal-title" id="modal-content-' . $item->id . '-label">No. Dokumen :
                //                     ' . $item->number_document . '
                //                 </h5>
                //             </div>
                //             <div class="modal-body">
                //             ' . \Illuminate\Support\Str::limit($item->content_file ?? 'N/A', 1000) . '
                //             </div>
                //             <div class="modal-footer">
                //                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                //             </div>
                //         </div>
                //     </div>
                // </div>';

                //     // Create the button that triggers the modal
                //     $button = '
                // <a data-bs-toggle="modal" data-bs-target="#modal-content-' . $item->id . '" class="btn icon btn-primary" title="Show">
                //     <i class="bi bi-eye"></i>
                // </a>';

                //     // Return both the button and the modal content
                //     return $button . $modal;
                // })
                ->rawColumns(['action', 'division.name'])
                ->toJson();
        }
        // $expirationDate = 0; // Initialize the variable outside the loop

        // foreach ($divisions as $division) {
        //     $archivesContainer = $division->archive_container;

        //     // Assuming $archivesContainer is a collection
        //     $expirationDate += $archivesContainer->filter(function ($archive) {
        //         return $archive->expiration_active < now()->toDateString();
        //     })->count();

        //     // Now $expirationDate accumulates the count of records that match the condition for each division
        // }

        // dd($expirationDate);
        return view('pages.transaction-archive.destruction-archive.index', compact('archives', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DestructionArchive $destructionArchive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestructionArchive $destructionArchive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestructionArchive $destructionArchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestructionArchive $destructionArchive)
    {
        //
    }

    public function checkDestroy(Request $request)
    {


        // Retrieve the approvals input
        $approvals = $request->input('approval', []);
        // dd($approvals);
        // Retrieve all archive IDs
        // $archiveIds = ArchiveContainer::where('division_id', $division_id)->pluck('id')->toArray();

        // Find the IDs that are not checked
        $uncheckedIds = array_keys($approvals);

        // Update the status for unchecked items
        if (! empty($uncheckedIds)) {
            ArchiveContainer::whereIn('id', $uncheckedIds)->update(['archive_status' => 'musnah']);
        }

        alert()->success('Success', 'Data updated successfully.');
        return redirect()->route('destruction-archive.index');
    }
    public function checkNotDestroy(Request $request)
    {

        // $id = $request->id;

        // $division_id = division::find($id);

        // Retrieve the approvals input
        $approvals = $request->input('approvals', []);

        // Retrieve all archive IDs
        // $archiveIds = ArchiveContainer::where('division_id', $division_id->id)->pluck('id')->toArray();

        // Find the IDs that are not checked
        // $uncheckedIds = array_diff($archiveIds, array_keys($approvals));

        $checkedIds = array_keys($approvals);

        // dd([$uncheckedIds]);

        // Update the status for unchecked items
        if (! empty($checkedIds)) {
            ArchiveContainer::whereIn('id', $checkedIds)->update(['archive_status' => 'musnah']);
        }

        alert()->success('Success', 'Data updated successfully.');
        return redirect()->back();
    }
    public function divisionDestruct($id)
    {
        try {
            $decrypt_id = decrypt($id);
        } catch (\Exception $e) {
            // If decryption fails, abort with a 404 error
            return abort(404);
        }
        // $archivesQuery = ArchiveContainer::with('division')->whereDate('expiration_inactive', '<', now()->toDateString())->orderBy('created_at', 'desc');

        $divisions = Division::with('archive_container')->findOrFail($decrypt_id);
        $archiveContainers = ArchiveContainer::where('division_id', $divisions->id)
            ->whereDate('expiration_inactive', '<', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->where('archive_status', 'baik')
            ->get();
        return view('pages.transaction-archive.destruction-archive.division-destruct', compact('divisions', 'archiveContainers'));
    }
    public function archiveDestroy()
    {
        // try {
        //     $decrypt_id = decrypt($id);
        // } catch (\Exception $e) {
        //     // If decryption fails, abort with a 404 error
        //     return abort(404);
        // }
        // $archivesQuery = ArchiveContainer::with('division')->whereDate('expiration_inactive', '<', now()->toDateString())->orderBy('created_at', 'desc');

        // $divisions = Division::with('archive_container')->findOrFail($decrypt_id);
        $archiveContainers = ArchiveContainer::orderBy('created_at', 'desc')
            ->where('archive_status', 'musnah')
            ->get();
        return view('pages.transaction-archive.destruction-archive.archive-destroy', compact('archiveContainers'));
    }
    public function cancelDestroy(Request $request)
    {
        // Retrieve the 'id' from the request
        $id = $request->id;
        // dd($id);
        // Find the archive container by ID
        $archive = ArchiveContainer::find($id);

        // Check if the archive container was found
        if (! $archive) {
            // If not found, redirect back with an error message
            alert()->error('Error', 'Data not found');
            return redirect()->back();
        }

        // Update the status of the archive container
        $archive->update(['archive_status' => 'baik']);

        // Display a success message
        alert()->success('Success', 'Data successfully updated');

        // Redirect back to the previous page
        return redirect()->back();
    }


}
