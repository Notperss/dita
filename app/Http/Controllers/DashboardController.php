<?php

namespace App\Http\Controllers;

use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->hasRole('Peminjam')) {
            // If the user has the role "Peminjam", redirect to the lending page
            return redirect()->route('backsite.lending-archive.index');
        }

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
        return view('pages.dashboard.index', compact('divisions', 'archiveContainers', 'lendingArchives', 'monthCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(403);
    }
}
