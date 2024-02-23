<?php

namespace App\Http\Controllers\MasterData\WorkUnits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\WorkUnits\Department;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Section;
use App\Models\MasterData\WorkUnits\Division;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::with('division', 'department')->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $divisions = Division::orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.create', compact('divisions', ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'division_id' => ['required', 'max:255'],
            'department_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Departemen harus diisi.',
            'department_id.required' => 'Nama Divisi harus diisi.',
            'division_id.required' => 'Nama Department harus diisi.',
            'name.max' => 'Nama Departemen tidak boleh lebih dari :max karakter.',
            'division_id.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            'department_id.max' => 'Nama Department tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the validation passes, create the Divisi record
        Section::create($request->all());

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.section.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sections = Section::find($id);
        $divisions = Division::orderBy('name', 'asc')->get();
        $departments = Department::where('division_id', $sections->division_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.edit', compact('divisions', 'departments', 'sections'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'division_id' => ['required', 'max:255'],
            'department_id' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Departemen harus diisi.',
            'department_id.required' => 'Nama Divisi harus diisi.',
            'division_id.required' => 'Nama Department harus diisi.',
            'name.max' => 'Nama Departemen tidak boleh lebih dari :max karakter.',
            'division_id.max' => 'Nama Divisi tidak boleh lebih dari :max karakter.',
            'department_id.max' => 'Nama Department tidak boleh lebih dari :max karakter.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $section->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('backsite.section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        $decrypt_id = decrypt($id);
        $section = Section::find($decrypt_id);

        // hapus location
        $section->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function getDepartments(Request $request)
    {
        $divisionId = $request->input('division_id');
        $departments = Department::where('division_id', $divisionId)->get();
        return response()->json($departments);
    }
}
