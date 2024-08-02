<?php

namespace App\Http\Controllers\TransactionArchive\FolderDivision;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionArchive\FolderDivision\ItemFileStoreRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionArchive\FolderDivision\FolderItem;
use App\Models\TransactionArchive\FolderDivision\FolderDivision;
use App\Models\TransactionArchive\FolderDivision\FolderItemFile;

class FolderDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = auth()->user();

        // $folders = FolderDivision::with('ancestors')->latest()->get();
        // Only get root folders (folders without a parent)
        $folderQuery = FolderDivision::whereIsRoot()->with('ancestors')->latest();
        $folderFilesQuery = FolderItemFile::latest();

        if (Gate::allows('super_admin')) {
            $folders = $folderQuery->get();
            $folderFiles = $folderFilesQuery->get();
        }
        //  elseif (Gate::allows('admin')) {
        //     $folders = $folderQuery->where('company_id', $auth->company_id)->get();
        //     $folderFiles = $folderFilesQuery->where('company_id', $auth->company_id)->get();
        // }
        else {
            $folders = $folderQuery->where('company_id', $auth->company_id)->where('division_id', $auth->division_id)->get();
            $folderFiles = $folderFilesQuery->where('company_id', $auth->company_id)->where('division_id', $auth->division_id)->get();
        }

        // Debugging
        // dd($folders);

        return view('pages.transaction-archive.folder-division.index', compact('folders', 'folderFiles'));
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
        // Custom validation messages
        $messages = [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'parent.exists' => 'The selected parent folder is invalid.',
        ];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'parent' => 'nullable|exists:folder_divisions,id', // Ensure the parent exists if provided
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            $errors = $validator->errors()->all();

            // Display errors using SweetAlert
            // alert()->error('Validation Error', implode('<br>', $errors));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $auth = auth()->user();

        $folders = FolderDivision::create([
            'company_id' => $auth->company_id,
            'division_id' => $auth->division_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_lock' => 0,
        ]);

        if ($request->parent && $request->parent !== 'none') {
            $node = FolderDivision::find($request->parent);
            $node->appendNode($folders);
        }

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the folder
        $folders = FolderDivision::findOrFail($id);

        // Load only direct children (not all descendants)
        $descendants = $folders->children()->get();

        // Load ancestors for breadcrumbs
        $ancestors = $folders->ancestors()->get();

        $files = FolderItemFile::where('folder_id', $folders->id)->latest()->get();
        // if ($folders->parent_id != null) {
        //     abort(404, 'Folder not found or is not a root folder');
        // }
        return view('pages.transaction-archive.folder-division.show', compact('folders', 'descendants', 'ancestors', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FolderDivision $folderDivision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
        ];

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated input data
        $data = $validator->validated();

        // Find the folder division by ID
        $folderDivision = FolderDivision::findOrFail($id);

        // Update the folder division with validated data
        $folderDivision->update($data);

        // Display a success message
        alert()->success('Sukses', 'Data berhasil diperbarui');

        // Redirect back to the previous page
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $folder = FolderDivision::findOrFail($id);
        $folder->delete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function form_upload(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $row = FolderDivision::findOrFail($id);
            $data = [
                'id' => $row['id'],
            ];

            $msg = [
                'data' => view('pages.transaction-archive.folder-division.upload_file', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    public function upload(Request $request)
    {
        // Custom validation messages
        $messages = [
            'required' => 'The :attribute field is required.',
            'max' => [
                'file' => 'Maximum file size to upload is 50MB.',
                'string' => ':attribute terlalu panjang (maks 250 karakter).',
            ],
            'unique' => ':attribute already been used.',
        ];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'number' => 'required', // Ensure the parent exists if provided
            'date' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'file.*' => 'required|max:51200' //50MB,
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Get the error messages
            $errors = $validator->errors()->all();

            // Display errors using SweetAlert
            // alert()->error('Validation Error', implode('<br>', $errors));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $auth = auth()->user();
        $folder = FolderDivision::find($request->id);

        $companyName = $auth->company->name ?? 'admin';
        $divisionCode = $auth->division->code ?? 'admin';

        // dd([$divisionName, $companyName]);

        $ancestors = $folder->ancestors()->get();

        $path = 'file-folder/' . $companyName . '/' . $divisionCode;

        foreach ($ancestors as $ancestor) {
            $path .= '/' . $ancestor->id;
        }
        $path .= '/' . $folder->id;

        $disk_root = config('filesystems.disks.d_drive.root');
        if (! file_exists($disk_root) || ! is_dir($disk_root)) {
            alert()->error('Error', 'Disk or path not found.');
            return redirect()->back()->withInput();
        }

        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                $file = $image->getClientOriginalName();
                $basename = pathinfo($file, PATHINFO_FILENAME) . '-' . Str::random(3);
                $ext = $image->getClientOriginalExtension();
                $fullname = $basename . '.' . $ext;
                $storedFile = $image->storeAs($path, $fullname, 'd_drive');
                $files[] = $storedFile;
            }
        }

        foreach ($files as $file) {
            FolderItemFile::create([
                'folder_id' => $request->id,
                'division_id' => $auth->division_id,
                'company_id' => $auth->company_id,
                // 'folder_item_id' => $folderItem->id,
                'number' => $request->number,
                'date' => $request->date,
                'description' => $request->description,
                'file' => $file,
            ]);
        }

        alert()->success('Success', 'File successfully uploaded');
        return redirect()->back();
    }

    public function delete_file($id)
    {
        $folderFile = FolderItemFile::find($id);
        $file = $folderFile->file;

        // $path_file = $file['file'];

        if ($file) {
            // Extract the original file name and extension
            $originalName = pathinfo($file, PATHINFO_FILENAME);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $checkedName = "(deleted) " . $originalName . '.' . $ext;

            // Define the new file path
            $newPath = dirname($file) . '/' . $checkedName;

            // Rename the file in the storage
            if (Storage::disk('d_drive')->exists($file)) {
                Storage::disk('d_drive')->move($file, $newPath);
            }

            // Update the folderFile record with the new name
            $folderFile->file = $newPath;
            $folderFile->update();
        }

        // find old photo
        // $path_file = $file['file'];

        // delete file
        // if ($path_file != null || $path_file != '') {
        //     Storage::delete($path_file);
        // }

        $folderFile->delete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function lockFolder($id)
    {
        $folderDivision = FolderDivision::find($id);
        if ($folderDivision) { // Check if the record exists
            if ($folderDivision->is_lock) { // Check if is_lock is true
                $folderDivision->is_lock = false;
                alert()->success('Success', 'Folder Terbuka!');
            } else { // Implicit check for is_lock being false
                $folderDivision->is_lock = true;
                alert()->success('Success', 'Folder Terkunci!');
            }
        } else {
            alert()->error('Error', 'Gagal Melakukan Eksekusi!');
            return redirect()->back();
        }
        // dd($folderDivision->is_lock);
        $folderDivision->save();

        return redirect()->back();
    }
    public function lockFolderFile($id)
    {
        $folderFile = FolderItemFile::find($id);
        if ($folderFile) { // Check if the record exists
            if ($folderFile->is_lock) { // Check if is_lock is true
                $folderFile->is_lock = false;
                alert()->success('Success', 'File Terbuka!');
            } else { // Implicit check for is_lock being false
                $folderFile->is_lock = true;
                alert()->success('Success', 'File Terkunci!');
            }
        } else {
            alert()->error('Error', 'Gagal Melakukan Eksekusi!');
            return redirect()->back();
        }
        // dd($folderFile->is_lock);
        $folderFile->save();

        return redirect()->back();
    }
}