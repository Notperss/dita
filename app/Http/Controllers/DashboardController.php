<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check() && ! (auth()->user()->can('super_admin') || auth()->user()->can('admin'))) {
            // If the user has either 'super_admin' or 'admin' permission, redirect to the lending page
            return redirect()->route('backsite.lending-archive.index');
        }

        $companies = auth()->user()->company_id;

        // $archivesQuery = ArchiveContainer::where('status', 1)->whereDate('expiration_active', '<', now()->toDateString())->orderBy('created_at', 'desc');

        if (Gate::allows('super_admin')) {
            $divisions = Division::with('archive_container')->get();
            $archiveContainers = ArchiveContainer::orderBy('created_at', 'desc')->take(10)->get();
            $lendingArchives = LendingArchive::orderBy('created_at', 'desc')->take(10)->get();

            $currentYear = date('Y'); // Get the current year
            $monthCounts = [];
            foreach (range(1, 12) as $month) {
                $count = ArchiveContainer::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();
                $monthCounts[] = $count;
            }
        } else {
            $divisions = Division::where('company_id', $companies)->with('archive_container')->get();
            $archiveContainers = ArchiveContainer::where('company_id', $companies)->orderBy('created_at', 'desc')->take(10)->get();
            $lendingArchives = LendingArchive::where('company_id', $companies)->orderBy('created_at', 'desc')->take(10)->get();

            $currentYear = date('Y'); // Get the current year
            $monthCounts = [];
            foreach (range(1, 12) as $month) {
                $count = ArchiveContainer::where('company_id', $companies)->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();
                $monthCounts[] = $count;
            }
        }


        return view('pages.dashboard.index', compact('divisions', 'archiveContainers', 'lendingArchives', 'monthCounts', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return abort(403);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(403);
    }

    public function division_archive($id)
    {
        // $id = $request->id;
        // $decrypt_id = decrypt($id);
        $divisions = Division::with('archive_container')->findOrFail($id);
        $archiveContainers = ArchiveContainer::where('division_id', $divisions->id)->get();
        return view('pages.dashboard.division-archive', compact('divisions', 'archiveContainers'));
    }
}
