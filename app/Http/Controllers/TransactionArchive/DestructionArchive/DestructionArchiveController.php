<?php

namespace App\Http\Controllers\TransactionArchive\DestructionArchive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Support\Facades\Gate;
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

        $archivesQuery = ArchiveContainer::whereDate('expiration_active', '<', now()->toDateString())->orderBy('created_at', 'desc');
        $divisionsQuery = Division::with('archive_container');

        // Filter archives and divisions based on user role
        if (Gate::allows('super_admin')) {
            $archives = $archivesQuery->get();
            $divisions = $divisionsQuery->get();
        } elseif (Gate::allows('admin')) {
            $archives = $archivesQuery->where('company_id', $company_id)->get();
            $divisions = $divisionsQuery->where('company_id', $company_id)->get();
        } else {
            $archives = $archivesQuery->where('status', 1)->where('company_id', $company_id)->where('division_id', $division_id)->get();
            $divisions = $divisionsQuery->where('company_id', $company_id)->where('id', $division_id)->get();
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

    public function approvalDestruction(Request $request)
    {
        $approvals = $request->input('approval');

        // Check if approvals array is empty
        if (empty($approvals)) {
            // Handle the case where no approvals are selected
            // For example, you could return a validation error message or redirect back with an error message
            alert()->error('Error', 'Harap pilih setidaknya satu');
            return redirect()->back();
        }

        foreach ($approvals as $archiveId => $approval) {
            // Assuming you have a boolean value in $approval indicating whether it's approved or not
            if ($approval) {
                ArchiveContainer::where('id', $archiveId)->update([
                    'status' => 10, // Assuming 10 represents "approved" status
                ]);
            } else {
                alert()->error('error', 'adjpajsd');
            }
        }

        alert()->success('Success', 'Data updated successfully.');
        return redirect()->route('backsite.destruction-archive.index');
    }
}
