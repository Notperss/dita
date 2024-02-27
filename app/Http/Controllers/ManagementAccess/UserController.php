<?php

namespace App\Http\Controllers\ManagementAccess;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ManagementAccess\TypeUser;
use App\Models\ManagementAccess\DetailUser;
use App\Http\Requests\ManagementAccess\User\StoreUserRequest;
use App\Http\Requests\ManagementAccess\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('name', '!=', 'Administrator')->orderBy('name', 'asc')->get();
        $type_user = TypeUser::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        return view('pages.management-access.user.index', compact('users', 'type_user'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('name', '!=', 'Administrator')->orderBy('name', 'asc')->get();
        $type_users = TypeUser::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        return view('pages.management-access.user.create', compact('users', 'type_users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // get all request from frontsite
        $data = $request->all();

        // hash password
        $data['password'] = Hash::make($data['password']);

        // store to database
        $user = User::create($data);
        $id = $user['id'];
        // $icon = $user['profile_photo_path'];

        // save to detail user , to set type user
        $detail_user = new DetailUser;
        // upload icon
        if ($request->hasFile('profile_photo_path')) {
            $detail_user->profile_photo_path = $request->file('profile_photo_path')->storeAs('assets/profile_photo_path', $id . '-' . $request->file('profile_photo_path')->getClientOriginalName());
        }
        $detail_user->user_id = $user['id'];
        $detail_user->type_user_id = $request['type_user_id'];
        $detail_user->nik = $request['nik'];
        $detail_user->job_position = $request['job_position'];
        $detail_user->status = $request['status'];
        $user->profile_photo_path = $detail_user['profile_photo_path'];
        $user->save();
        $detail_user->save();

        alert()->success('Sukses', 'User berhasil ditambahkan');
        return redirect()->route('backsite.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // deskripsi id
        // $decrypt_id = decrypt($id);
        $user = User::find($id);

        $type_user = TypeUser::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        return view('pages.management-access.user.edit', compact('user', 'type_user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // get all request from frontsite
        $data = $request->all();
        $id = $user->id;

        // get data
        $path_icon = $user->detail_user->profile_photo_path;

        // cek ada update password atau tidak
        if ($request->password != null) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        // update to database
        $user->update($data);

        // save to detail user , to set type user
        $detail_user = DetailUser::find($user['id']);
        // upload process here
        // upload icon
        if ($request->hasFile('profile_photo_path')) {
            $detail_user->profile_photo_path = $request->file('profile_photo_path')->storeAs('assets/profile_photo_path', $id . '-' . $request->file('profile_photo_path')->getClientOriginalName());
            // hapus file
            if ($path_icon != null || $path_icon != '') {
                Storage::delete($path_icon);
            }
        } else {
            $detail_user->profile_photo_path = $path_icon;
        }
        $detail_user->type_user_id = $request['type_user_id'];
        $detail_user->nik = $request['nik'];
        $detail_user->job_position = $request['job_position'];
        $detail_user->status = $request['status'];
        $user->profile_photo_path = $detail_user['profile_photo_path'];
        $user->save();
        $detail_user->save();

        alert()->success('Sukses', 'User berhasil diupdate');
        return redirect()->route('backsite.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        $decrypt_id = decrypt($id);
        $user = User::find($decrypt_id);

        // hapus user
        $user->forceDelete();

        // Hapus Detail User
        $detail_user = DetailUser::find($user['id']);
        // cari old icon
        $path_icon = $detail_user['profile_photo_path'];
        // hapus icon
        if ($path_icon != null || $path_icon != '') {
            Storage::delete($path_icon);
        }
        // dd($detail_user);
        $detail_user->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
