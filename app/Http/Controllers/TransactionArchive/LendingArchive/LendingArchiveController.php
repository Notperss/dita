<?php

namespace App\Http\Controllers\TransactionArchive\LendingArchive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $archiveContainers = ArchiveContainer::orderBy('number_archive', 'asc')->get();
        return view('pages.transaction-archive.lending-archive.index', compact('archiveContainers'));
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
        Lending::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.lending-archive.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(LendingArchive $lendingArchive)
    {
        //
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
}
