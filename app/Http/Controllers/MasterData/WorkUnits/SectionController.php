<?php

namespace App\Http\Controllers\MasterData\WorkUnits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Section;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\MasterData\WorkUnits\Department;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('section_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $sections = Section::where('company_id', $company_id)->with('division', 'department')->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('section_create')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;
        $divisions = Division::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.create', compact('divisions', ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('section_store')) {
            abort(403);
        }
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
        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        // If the validation passes, create the Divisi record
        Section::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('backsite.section.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('section_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $sections = Section::find($id);
        $divisions = Division::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $departments = Department::where('division_id', $sections->division_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.work-units.section.edit', compact('divisions', 'departments', 'sections'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        if (! Gate::allows('section_update')) {
            abort(403);
        }
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
        if (! Gate::allows('section_destroy')) {
            abort(403);
        }
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
