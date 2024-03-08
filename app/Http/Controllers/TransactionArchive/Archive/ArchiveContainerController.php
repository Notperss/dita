<?php

namespace App\Http\Controllers\TransactionArchive\Archive;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\WorkUnits\Section;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\MasterData\Location\ContainerLocation;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\MasterData\Classification\MainClassification;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\MasterData\Retention\RetentionArchives;

class ArchiveContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {


            $archiveContainers = ArchiveContainer::with('division')->orderBy('id', 'asc');

            return DataTables::of($archiveContainers)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
             <a type="button" title="Tambah File" class="btn icon btn-sm btn-info" onclick=""><i
                      class="bi bi-files"></i></a>
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       <a href="#mymodal" data-remote="' . route('backsite.archive-container.show', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                        Show
                    </a>
                        <a class="dropdown-item"
                          href="' . route('backsite.archive-container.edit', $item->id) . '">Edit</a>
                        <a class="dropdown-item" onclick="showSweetAlert(' . $item->id . ')">Delete</a>
                      </div>
                    </div>
                  </div>
                  <form id="deleteForm_' . $item->id . '"
                    action="' . route('backsite.archive-container.destroy', $item->id) . '"
                    method="POST">
                    ' . method_field('delete') . csrf_field() . '
                  </form>
                ';
                })
                ->rawColumns(['action',])
                ->toJson();
        }
        // $archiveContainers = ArchiveContainer::orderBy('id', 'asc')->get();
        return view('pages.transaction-archive.archive-container.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $archiveContainersId = ArchiveContainer::find($id);
        $archiveContainers = ArchiveContainer::orderBy('id', 'asc')->get();
        $divisions = Division::orderBy('id', 'asc')->get();
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        // $numberContainers = ContainerLocation::with('mainLocation')->where('division_id', $archiveContainersId->division_id)->get();
        // $divisions = Division::orderBy('id', 'asc')->get();
        // $sections = Section::orderBy('id', 'asc')->get();
// Get the last ContainerLocation record
        $lastArchiveContainer = ArchiveContainer::latest()->first();

        if ($lastArchiveContainer) {
            $numberContainers = ContainerLocation::with('mainLocation')
                ->where('division_id', $lastArchiveContainer->division_id)
                ->get();
        } else {
            // Handle the case when there is no data in the archiveContainer table
            $numberContainers = collect(); // or any other appropriate default value
        }
        return view('pages.transaction-archive.archive-container.create',
            compact('archiveContainers', 'archiveContainersId', 'divisions', 'mainClassifications', 'numberContainers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // // Validate the request data
        // $validator = Validator::make($request->all(), [
        //     'division_id' => ['required'],
        //     'number_container' => ['required'],

        //     // Add other validation rules as needed
        // ], [
        //     'division_id.required' => 'Nama Divisi harus diisi.',
        //     'number_container.required' => 'Nomor Kontainer harus diisi.',
        //     // Add custom error messages for other rules
        // ]);
        // // Check if validation fails
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // If the validation passes, create the MainLocation record
        // get all request from frontsite

        // Validate the form data
        $request->validate([
            'main_location' => 'required|string',
            'sub_location' => 'required|string',
            'detail_location' => 'required|string',
            // 'description_location' => 'required|string',
            'number_archive' => 'required|string',
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            // 'retention' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            'amount' => 'required|string',
            'archive_in' => 'required|date',
            // 'expiration_date' => 'required',
            'year' => 'required|string',
            'subseries' => 'required|string',
            'number_container' => 'required|string',
            'file' => 'required|file|mimes:pdf',
            'division_id' => 'required|confirmed',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'file' => 'Kolom :attribute harus berupa file.',
            'mimes' => 'File :attribute harus berformat PDF.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
        ]);
        // dd($request->all());
        try {
            // Retrieve form data
            $data = $request->all();

            // Process file upload
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                $file = $files->getClientOriginalName();
                $basename = pathinfo($file, PATHINFO_FILENAME) . '-' . Str::random(5);
                $extension = $files->getClientOriginalExtension();
                $fullname = $basename . '.' . $extension;

                if ($files->getClientOriginalExtension() == 'pdf') {
                    // Specify the path to pdftotext executable
                    $pdftotextPath = 'C:/Program Files/Git/mingw64/bin/pdftotext.exe';

                    // Use spatie/pdf-to-text to extract text from the PDF
                    $text = (new Pdf($pdftotextPath))
                        ->setPdf($files->getRealPath())
                        ->text();

                    // Filter out non-alphabetic characters from the extracted text
                    // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
                    $filteredText = preg_replace("/[^a-zA-Z0-9 ,.\/=()]/", "", $text);

                    // Store the filtered text in the 'content_file' column
                    $data['content_file'] = $filteredText;
                }

                // Store the file in the specified directory
                $data['file'] = $files->storeAs('assets/file-arsip/' . $data['subseries'] . '/' . $data['number_container'], $fullname);
            } else {
                // Handle the case where no file was uploaded
                // You may want to return an error message or redirect back to the form
                alert()->error('Error', 'No file uploaded. Please upload a file.');
                return redirect()->back()->withInput();
            }

            // Start a database transaction
            DB::beginTransaction();

            try {
                // Store to database
                ArchiveContainer::create($data);

                // Commit the transaction if everything is successful
                DB::commit();

                alert()->success('Success', 'Data successfully added');
                return redirect()->back()->withInput();
                // return redirect()->route('backsite.archive-container.index');
            } catch (\Exception $e) {
                // Rollback the transaction in case of an error
                DB::rollBack();

                // Log the error
                Log::error("Database transaction error: " . $e->getMessage());

                // Provide feedback to the user or redirect with an error message
                alert()->error('Error', 'Failed to add data. Please try again.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error("File upload or text extraction error: " . $e->getMessage());

            // Provide feedback to the user or redirect with an error message
            alert()->error('Error', 'Failed to process the file. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $archiveContainers = ArchiveContainer::find($id);

        $filepath = storage_path($archiveContainers->file);
        $fileName = basename($filepath);
        return view('pages.transaction-archive.archive-container.show',
            compact(
                'archiveContainers',
                'fileName',
            ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $archiveContainers = ArchiveContainer::find($id);
        $divisions = Division::orderBy('id', 'asc')->get();
        $locationContainers = ContainerLocation::where('division_id', $archiveContainers->division_id)->orderBy('id', 'asc')->get();
        $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('main_classification_id', $archiveContainers->main_classification_id)->get();
        $retentions = RetentionArchives::where('sub_classification_id', $archiveContainers->sub_classification_id)->get();
        // $divisions = Division::orderBy('id', 'asc')->get();
        $sections = Section::orderBy('id', 'asc')->get();

        $filepath = storage_path($archiveContainers->file);
        $fileName = basename($filepath);
        return view('pages.transaction-archive.archive-container.edit',
            compact(
                'archiveContainers',
                'locationContainers',
                'divisions',
                'mainClassifications',
                'subClassifications',
                'retentions',
                'fileName',
                'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchiveContainer $archiveContainer)
    {
        $request->validate([
            'main_location' => 'required|string',
            'sub_location' => 'required|string',
            'detail_location' => 'required|string',
            // 'description_location' => 'required|string',
            'number_archive' => 'required|string',
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            'retention' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            'amount' => 'required|string',
            'archive_in' => 'required|date',
            'expiration_date' => 'required',
            'year' => 'required|string',
            'subseries' => 'required|string',
            'number_container' => 'required|string',
            'file' => 'file|mimes:pdf',
            'division_id' => 'required|confirmed',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'file' => 'Kolom :attribute harus berupa file.',
            'mimes' => 'File :attribute harus berformat PDF.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
        ]);
        // dd($request->all());
        try {
            // Retrieve form data
            $data = $request->all();

            // Process file upload
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                $file = $files->getClientOriginalName();
                $basename = pathinfo($file, PATHINFO_FILENAME) . '-' . Str::random(5);
                $extension = $files->getClientOriginalExtension();
                $fullname = $basename . '.' . $extension;

                if ($files->getClientOriginalExtension() == 'pdf') {
                    // Specify the path to pdftotext executable
                    $pdftotextPath = 'C:/Program Files/Git/mingw64/bin/pdftotext.exe';

                    // Use spatie/pdf-to-text to extract text from the PDF
                    $text = (new Pdf($pdftotextPath))
                        ->setPdf($files->getRealPath())
                        ->text();

                    // Filter out non-alphabetic characters from the extracted text
                    // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
                    $filteredText = preg_replace("/[^a-zA-Z0-9 ,.\/=()]/", "", $text);

                    // Store the filtered text in the 'content_file' column
                    $data['content_file'] = $filteredText;
                }

                // Store the file in the specified directory
                $data['file'] = $files->storeAs('assets/file-arsip/' . $data['subseries'] . '/' . $data['number_container'], $fullname);
            }
            // else {
            //     // Handle the case where no file was uploaded
            //     // You may want to return an error message or redirect back to the form
            //     alert()->error('Error', 'No file uploaded. Please upload a file.');
            //     return redirect()->back()->withInput();
            // }

            // Start a database transaction
            DB::beginTransaction();

            try {
                // Store to database
                // get all request from frontsite

                $archiveContainer->update($data);


                // Commit the transaction if everything is successful
                DB::commit();

                alert()->success('Success', 'Data successfully added');
                // return redirect()->back()->withInput();
                return redirect()->route('backsite.archive-container.index');
            } catch (\Exception $e) {
                // Rollback the transaction in case of an error
                DB::rollBack();

                // Log the error
                Log::error("Database transaction error: " . $e->getMessage());

                // Provide feedback to the user or redirect with an error message
                alert()->error('Error', 'Failed to add data. Please try again.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error("File upload or text extraction error: " . $e->getMessage());

            // Provide feedback to the user or redirect with an error message
            alert()->error('Error', 'Failed to process the file. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        // $decrypt_id = decrypt($id);
        $archiveContainer = ArchiveContainer::find($id);
        // dd($archiveContainer);
        // hapus location
        $archiveContainer->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    public function form_upload(Request $request)
    {
        if ($request->ajax()) {

            $archiveContainers = ArchiveContainer::orderBy('id', 'asc')->get();
            $divisions = Division::orderBy('id', 'asc')->get();
            $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
            // $divisions = Division::orderBy('id', 'asc')->get();
            $sections = Section::orderBy('id', 'asc')->get();
            $data = [
                'archiveContainers' => $archiveContainers,
                'divisions' => $divisions,
                'sections' => $sections,
                'mainClassifications' => $mainClassifications,
            ];

            $msg = [
                'data' => view('pages.transaction-archive.archive-container.form-upload', $data)->render(),
            ];

            return response()->json($msg);
        }
    }

    public function getNumberContainer(Request $request)
    {
        $divisionId = $request->input('division_id');
        $detailLocations = ContainerLocation::with('mainLocation')->where('division_id', $divisionId)->get();

        // Extracting relevant data and adding 'name' property
        $formattedDetailLocations = $detailLocations->map(function ($detailLocation) {
            return [
                'id' => $detailLocation->id,
                'number_container' => $detailLocation->number_container,
                'nameMainLocation' => $detailLocation->mainLocation->name, // Assuming 'name' is a property in the 'mainLocation' model
                'nameSubLocation' => $detailLocation->subLocation->name, // Assuming 'name' is a property in the 'mainLocation' model
                'nameDetailLocation' => $detailLocation->detailLocation->name, // Assuming 'name' is a property in the 'mainLocation' model
                'descriptionLocation' => $detailLocation->description, // Assuming 'name' is a property in the 'mainLocation' model
            ];
        });

        return response()->json($formattedDetailLocations);
    }
    public function getDataContainer(Request $request)
    {
        $numberId = $request->input('number_container');
        $detailNumbers = ArchiveContainer::where('number_container', $numberId)->orderBy('created_at', 'desc')->get();

        // Extracting relevant data and adding 'name' property
        $formattedDetailLocations = $detailNumbers->map(function ($detailNumber) {
            return [
                'id' => $detailNumber->id,
                'number_container' => $detailNumber->number_container,
                'number_archive' => $detailNumber->number_archive, // Assuming 'name' is a property in the 'mainLocation' model
                'expiration_date' => $detailNumber->expiration_date, // Assuming 'name' is a property in the 'mainLocation' model
                'archive_type' => $detailNumber->archive_type, // Assuming 'name' is a property in the 'mainLocation' model
            ];
        });

        return response()->json($formattedDetailLocations);
    }
}
