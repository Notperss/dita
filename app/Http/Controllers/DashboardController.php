<?php

namespace App\Http\Controllers;

use App\Models\MasterData\Company\Company;
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
            if (auth()->user()->hasRole('folder-division')) {
                return redirect()->route('folder.index');
            } elseif (auth()->user()->can('all_archive')) {
                return redirect()->route('dataArchive');
            } else {

                return redirect()->route('lending-archive.index');
            }
        }

        $companyId = auth()->user()->company_id;
        $isSuperAdmin = auth()->user()->hasRole('super-admin');

        // Work Units (Companies with Divisions)
        $workUnits = Company::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('id', $companyId);
        })->with('division')
            ->orderBy('name', 'asc')
            ->get();

        // Archive Containers latest 10
        $archiveContainers = ArchiveContainer::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Lending Top 10
        $lendingTopten = LendingArchive::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.dashboard.index',
            compact(
                'workUnits',
                'archiveContainers',
                'lendingTopten',
                'companyId',
            ));
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

    public function getChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $monthCounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $count = ArchiveContainer::when(! auth()->user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', auth()->user()->company_id);
            })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                ->count();

            $monthCounts[] = $count;
        }

        return response()->json([
            'data' => $monthCounts,
        ]);
    }

    public function getLendingChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $total = [];
        $digital = [];
        $physic = [];

        for ($i = 1; $i <= 12; $i++) {
            $baseQuery = LendingArchive::query()
                ->when(! auth()->user()->hasRole('super-admin'), function ($query) {
                    $query->where('company_id', auth()->user()->company_id);
                })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $i);

            $total[] = (clone $baseQuery)->count();
            $digital[] = (clone $baseQuery)->where('document_type', 'DIGITAL')->count();
            $physic[] = (clone $baseQuery)->where('document_type', 'FISIK')->count();
        }

        return response()->json([
            'total' => $total,
            'digital' => $digital,
            'physic' => $physic,
        ]);
    }


    public function division_archive($id)
    {
        // $id = $request->id;
        // $decrypt_id = decrypt($id);
        $divisions = Division::with('archive_container')->findOrFail($id);
        $archiveContainers = ArchiveContainer::where('division_id', $divisions->id)->get();
        return view('pages.dashboard.division-archive', compact('divisions', 'archiveContainers'));
    }

    public function division_lending($id)
    {
        $divisions = Division::with('lendingArchive')->findOrFail($id);
        $lendingArchives = LendingArchive::where('division_id', $divisions->id)->get();
        return view('pages.dashboard.division-lending', compact('divisions', 'lendingArchives'));
    }
}
