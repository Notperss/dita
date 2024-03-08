<?php

namespace App\Http\Controllers\TransactionArchive\ArchiveFile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionArchive\ArchiveFile\ArchiveFile;

class ArchiveFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return abort(404);
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
        return abort(404);

    }

    /**
     * Display the specified resource.
     */
    public function show(ArchiveFile $archiveFile)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArchiveFile $archiveFile)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchiveFile $archiveFile)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchiveFile $archiveFile)
    {
        return abort(404);
    }

    public function form_upload(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $row = ArchiveFile::find($id);
            $data = [
                'id' => $row['id'],
            ];

            $msg = [
                'data' => view('pages.data.daily_activity.upload_file', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    // upload file
    public function upload(Request $request)
    {
        // save to file test material
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                $file = $image->storeAs('assets/file-daily-activity', $image->getClientOriginalName());
                DailyActivityFile::create([
                    'daily_activity_id' => $request->id,
                    'file' => $file,
                ]);
            }
        }

        alert()->success('Sukses', 'File Berhasil diupload');
        return redirect()->route('backsite.daily_activity.index');
    }

    // get show_file software
    public function show_file(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $daily_activity_file = DailyActivityFile::where('daily_activity_id', $id)->get();
            $data = [
                'datafile' => $daily_activity_file,
            ];

            $msg = [
                'data' => view('pages.data.daily_activity.detail_file', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    // hapus file dailiy activity
    public function hapus_file($id)
    {
        $daily_activity_file = DailyActivityFile::find($id);

        // cari old photo
        $path_file = $daily_activity_file['file'];

        // hapus file
        if ($path_file != null || $path_file != '') {
            Storage::delete($path_file);
        }

        $daily_activity_file->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

}
