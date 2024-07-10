<?php

namespace App\Http\Controllers\ManagementAccess;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ManagementAccess\TypeUser;
use Illuminate\Support\Facades\Validator;

class TypeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_users = TypeUser::orderBy('name', 'asc')->get();
        return view('pages.management-access.type-user.index', compact('type_users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.management-access.type-user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('type_users')],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Tipe User harus diisi.',
            'name.max' => 'Tipe User tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Tipe User sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // get all request from frontsite
        $data = $request->all();

        // store to database
        TypeUser::create($data);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('type_user.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(TypeUser $typeUser)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeUser $typeUser)
    {
        $id = $typeUser->id;
        $type_users = TypeUser::find($id);
        return view('pages.management-access.type-user.edit', compact('type_users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeUser $typeUser)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', Rule::unique('type_users')->ignore($typeUser->id)],
            // Add other validation rules as needed
        ], [
            'name.required' => 'Tipe User harus diisi.',
            'name.max' => 'Tipe User tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Tipe User sudah digunakan.',
            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        // update to database
        $typeUser->update($data);
        alert()->success('Sukses', 'Data berhasil diupdate');
        return redirect()->route('type_user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // deskripsi id
        $decrypt_id = decrypt($id);
        $type_user = TypeUser::find($decrypt_id);

        // hapus daily activity
        $type_user->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
