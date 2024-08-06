<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ArchiveContainerLog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\FolderDivision\FolderItemFile;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::latest()->get();

        if (request()->ajax()) {
            return DataTables::of($activities)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $content = view('pages.activity-log.content', compact('item'))->render();

                    if (Gate::allows('super_admin')) {
                        $modal = '
                <div class="modal fade" id="modal-content-' . $item->id . '" tabindex="-1" aria-labelledby="modalLabel-' . $item->id . '" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel-' . $item->id . '">log Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            ' . $content . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';

                        // Create the button that triggers the modal
                        $button = '
                <a data-bs-toggle="modal" data-bs-target="#modal-content-' . $item->id . '" class="btn icon btn-primary" title="Show">
                    <i class="bi bi-eye"></i>
                </a>';

                        // Return both the button and the modal content
                        return $button . $modal;
                    }
                })
                ->editColumn('causer', function ($item) {
                    $causerName = optional($item->causer)->name ?? 'N/A';
                    $causerRole = optional($item->causer)->getRoleNames() ?? 'N/A';
                    return $causerName . ' ' . $causerRole;
                })
                ->editColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->diffForHumans() ?? 'N/A';
                })
                // ->editColumn('regarding', function ($item) {

                // })
                ->rawColumns(['action',])
                ->toJson();
        }

        return view('pages.activity-log.index', compact('activities'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function viewFileArchive($id)
    {
        // Find the archive container or fail
        $archiveContainer = ArchiveContainer::findOrFail($id);

        // Log the view action
        ArchiveContainerLog::create([
            'archive_container_id' => $archiveContainer->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'action' => 'viewed-archive',
        ]);

        // Define the disk to use
        $disk = Storage::disk('nas');

        // Check if the file exists
        if (! $disk->exists($archiveContainer->file)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Get the file path
        $filePath = $disk->path($archiveContainer->file);

        // Return the file
        return response()->file($filePath);
    }

    public function downloadFileArchive($id)
    {
        $archiveContainer = ArchiveContainer::findOrFail($id);

        // Increment downloads
        // $archiveContainer->increment('downloads');

        // Log the download action
        ArchiveContainerLog::create([
            'archive_container_id' => $archiveContainer->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'action' => 'download-archive',
        ]);

        // Check if the file exists in storage
        $filePath = Storage::disk('nas')->path($archiveContainer->file);
        if (! Storage::disk('nas')->exists($archiveContainer->file)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Return the file
        return response()->file($filePath);
    }
    public function downloadFileFolder($id)
    {
        $folderFile = FolderItemFile::findOrFail($id);
        // dd($folderFile->file);

        // Increment downloads
        // $archiveContainer->increment('downloads');

        // Log the download action
        ArchiveContainerLog::create([
            // 'archive_container_id' => $folderFile->id,
            'folder_file_id' => $folderFile->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'action' => 'download-file-folder',
        ]);

        // Check if the file exists in storage
        $filePath = Storage::disk('nas')->path($folderFile->file);
        if (! Storage::disk('nas')->exists($folderFile->file)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Return the file
        return response()->file($filePath);
    }

    // public function moveFileArchive($id)
    // {
    //     // Find the archive container or fail
    //     $archiveContainer = ArchiveContainer::findOrFail($id);

    //     // Log the view action
    //     ArchiveContainerLog::create([
    //         'archive_container_id' => $archiveContainer->id,
    //         'user_id' => auth()->id(),
    //         'ip_address' => request()->ip(),
    //         'action' => 'move-archive',
    //     ]);

    //     // Define the disk to use
    //     $disk = Storage::disk('nas');

    //     // Check if the file exists
    //     if (! $disk->exists($archiveContainer->file)) {
    //         return response()->json(['error' => 'File not found.'], 404);
    //     }

    //     // Get the file path
    //     $filePath = $disk->path($archiveContainer->file);

    //     // Return the file
    //     return response()->file($filePath);
    // }

}
