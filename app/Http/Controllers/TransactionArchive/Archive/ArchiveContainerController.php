<?php

namespace App\Http\Controllers\TransactionArchive\Archive;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\MasterData\WorkUnits\Section;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\MasterData\Location\ContainerLocation;
use App\Models\MasterData\Retention\RetentionArchives;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\MasterData\Classification\MainClassification;

class ArchiveContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('archive_container_index')) {
            abort(403);
        }

        if (request()->ajax()) {

            $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user


            $archiveContainers = ArchiveContainer::where('archive_containers.company_id', $company_id)->with('division');

            return DataTables::of($archiveContainers)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
             <a href="#mymodal" data-remote="' . route('backsite.showBarcodeContainer', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="QR Code" class="btn icon btn-info">
                        <i class="bi bi-qr-code-scan"></i>
                    </a>
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary btn dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       <a href="#mymodal" data-remote="' . route('backsite.archive-container.show', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                         <i class="bi bi-eye"></i> Detail
                    </a>
                        <a class="dropdown-item"
                          href="' . route('backsite.archive-container.edit', $item->id) . '"><i class="bi bi-pencil"></i> Edit</a>
                        <a class="dropdown-item" onclick="showSweetAlert(' . $item->id . ')"><i class="bi bi-x-lg"></i> Delete</a>
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
        if (! Gate::allows('archive_container_create')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user

        $id = $request->id;
        $archiveContainersId = ArchiveContainer::find($id);
        $archiveContainers = ArchiveContainer::where('company_id', $company_id)->orderBy('id', 'asc')->get();
        $divisions = Division::where('company_id', $company_id)->orderBy('id', 'asc')->get();
        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        // $numberContainers = ContainerLocation::with('mainLocation')->where('division_id', $archiveContainersId->division_id)->get();
        // $divisions = Division::orderBy('id', 'asc')->get();
        // $sections = Section::orderBy('id', 'asc')->get();
// Get the last ContainerLocation record
        $lastArchiveContainer = ArchiveContainer::latest()->first();

        if ($lastArchiveContainer) {
            $numberContainers = ContainerLocation::where('company_id', $company_id)->with('mainLocation')
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
            // 'main_location' => 'required|string',
            // 'sub_location' => 'required|string',
            // 'detail_location' => 'required|string',
            // 'description_location' => 'required|string',
            // 'number_archive' => 'required|string',
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            // 'retention' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            // 'amount' => 'required|string',
            'archive_in' => 'required|date',
            // 'expiration_date' => 'required',
            'number_app' => 'required|string|unique:archive_containers',
            // 'number_catalog' => 'required|string',
            // 'number_document' => 'required|string',
            'number_container' => 'required|string',
            'year' => 'required|string',
            'subseries' => 'required|string',
            // 'file' => 'required|file|mimes:pdf|max:290',
            'file' => 'file|mimes:pdf|max:290',
            'division_id' => 'required|confirmed',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'file' => 'Kolom :attribute harus berupa file.',
            'max' => 'Nama :attribute terlalu panjang (maks 100 karakter).',
            'mimes' => 'File :attribute harus berformat PDF.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
            'unique' => 'Data :attribute sudah ada.',
        ]);
        // dd($request->all());

        // Retrieve form data
        $data = $request->all();

        // Assuming you have a 'division_id' field in your data
        if (isset($data['division_id'])) {
            // Retrieve data related to the division
            $divisionData = Division::findOrFail($data['division_id'])->code;
            // Here, 'code' is the attribute you want to retrieve from the Division model

            // Now, you can use $divisionData as needed
            // For example, you can attach it to the $data array
            $data['division_code'] = $divisionData;
        }

        // Process file upload only if a file is uploaded
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            if ($files->getClientOriginalExtension() == 'pdf') {
                // Specify the path to pdftotext executable
                // $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';

                // // Use spatie/pdf-to-text to extract text from the PDF
                // $text = (new Pdf($pdftotextPath))
                //     ->setPdf($files->getRealPath())
                //     ->text();
                $text = (new Pdf())
                    ->setPdf($files->getRealPath())
                    ->text();

                // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
                $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

                // Get the first 100 characters from the filtered text
                $first200Chars = substr($filteredText, 0, 180);

                // Store the filtered text in the 'content_file' column
                $data['content_file'] = $filteredText;
            }

            $file = $files->getClientOriginalName();
            $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first200Chars . ' )' . '-' . Str::random(5);
            $extension = $files->getClientOriginalExtension();
            $fullname = $basename . '.' . $extension;

            // Store the file in the specified directory
            $data['file'] = $files->storeAs('assets/file-arsip/' . $data['division_code'] . '/' . $data['number_container'], $fullname);

            if ($data['file'] === false) {
                // Handle the error
                alert()->error('Error', 'Failed to upload file');
                return redirect()->back()->withInput();
            }
        }
        $company_id = Auth::user()->company_id;

        // Merge the company_id into the request data
        $requestData = array_merge($data, ['company_id' => $company_id]);
        // Store to database
        ArchiveContainer::create($requestData);

        alert()->success('Success', 'Data successfully added');
        return redirect()->back()->withInput();



        // try {
        //     // Retrieve form data
        //     $data = $request->all();

        //     // Process file upload
        //     if ($request->hasFile('file')) {
        //         $files = $request->file('file');


        //         if ($files->getClientOriginalExtension() == 'pdf') {
        //             // Specify the path to pdftotext executable
        //             $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';

        //             // Use spatie/pdf-to-text to extract text from the PDF
        //             $text = (new Pdf($pdftotextPath))
        //                 ->setPdf($files->getRealPath())
        //                 ->text();

        //             // $text = (new Pdf())
        //             //     ->setPdf($files->getRealPath())
        //             //     ->text();

        //             // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
        //             // $filteredText = preg_replace("/[^a-zA-Z0-9 ,.\/=()]/", "", $text);
        //             $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

        //             // Get the first 100 characters from the filtered text
        //             $first200Chars = substr($filteredText, 0, 180);

        //             // Store the filtered text in the 'content_file' column
        //             $data['content_file'] = $filteredText;
        //         }

        //         $file = $files->getClientOriginalName();
        //         $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first200Chars . ' )' . '-' . Str::random(5);
        //         $extension = $files->getClientOriginalExtension();
        //         $fullname = $basename . '.' . $extension;

        //         // Store the file in the specified directory
        //         $data['file'] = $files->storeAs('assets/file-arsip/' . $data['subseries'] . '/' . $data['number_container'], $fullname);

        //         if ($data['file'] === false) {
        //             // Handle the error
        //             alert()->error('Error', 'Failed to upload file');
        //             return redirect()->back()->withInput();
        //         }
        //     } else {
        //         // Handle the case where no file was uploaded
        //         // You may want to return an error message or redirect back to the form
        //         alert()->error('Error', 'No file uploaded. Please upload a file.');
        //         return redirect()->back()->withInput();
        //     }
        //     // dd($data);
        //     // ArchiveContainer::create($data);

        //     // Start a database transaction
        //     DB::beginTransaction();

        //     try {
        //         $company_id = Auth::user()->company_id;

        //         // Merge the company_id into the request data
        //         $requestData = array_merge($data, ['company_id' => $company_id]);
        //         // Store to database
        //         ArchiveContainer::create($requestData);

        //         // Commit the transaction if everything is successful
        //         DB::commit();

        //         alert()->success('Success', 'Data successfully added');
        //         return redirect()->back()->withInput();
        //         // return redirect()->route('backsite.archive-container.index');
        //     } catch (\Exception $e) {
        //         // Rollback the transaction in case of an error
        //         DB::rollBack();

        //         // Log the error
        //         Log::error("Database transaction error: " . $e->getMessage());

        //         // Provide feedback to the user or redirect with an error message
        //         alert()->error('Error', 'Failed to add data. Please try again.');
        //         return redirect()->back()->withInput();
        //     }
        // } catch (\Exception $e) {
        //     // Log the error
        //     Log::error("File upload or text extraction error: " . $e->getMessage());

        //     // Provide feedback to the user or redirect with an error message
        //     alert()->error('Error', 'Failed to process the file. Please try again.');
        //     return redirect()->back()->withInput();
        // }

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
        $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user

        $archiveContainers = ArchiveContainer::find($id);
        $divisions = Division::where('company_id', $company_id)->orderBy('id', 'asc')->get();
        $locationContainers = ContainerLocation::where('division_id', $archiveContainers->division_id)->orderBy('id', 'asc')->get();
        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
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
        if (! Gate::allows('archive_container_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            // 'main_location' => 'required|string',
            // 'sub_location' => 'required|string',
            // 'detail_location' => 'required|string',
            // 'description_location' => 'required|string',
            // 'number_archive' => 'required|string',
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            // 'retention' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            // 'amount' => 'required|string',
            'archive_in' => 'required|date',
            // 'expiration_date' => 'required',
            'number_app' => [
                'required',
                'string',
                Rule::unique('archive_containers')->ignore($archiveContainer->id),
            ],
            // 'number_catalog' => 'required|string',
            // 'number_document' => 'required|string',
            'number_container' => 'required|string',
            'year' => 'required|string',
            'subseries' => 'required|string',
            // 'file' => 'required|file|mimes:pdf|max:290',
            'file' => 'file|mimes:pdf|max:290',
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

        // Retrieve form data
        $data = $request->all();

        $path_file = $archiveContainer['file'];
        // Process file upload only if a file is uploaded
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            if ($files->getClientOriginalExtension() == 'pdf') {
                // Specify the path to pdftotext executable
                // $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';

                // // Use spatie/pdf-to-text to extract text from the PDF
                // $text = (new Pdf($pdftotextPath))
                //     ->setPdf($files->getRealPath())
                //     ->text();
                $text = (new Pdf())
                    ->setPdf($files->getRealPath())
                    ->text();

                // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
                $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

                // Get the first 100 characters from the filtered text
                $first200Chars = substr($filteredText, 0, 180);

                // Store the filtered text in the 'content_file' column
                $data['content_file'] = $filteredText;
            }

            $file = $files->getClientOriginalName();
            $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first200Chars . ' )' . '-' . Str::random(5);
            $extension = $files->getClientOriginalExtension();
            $fullname = $basename . '.' . $extension;

            // Store the file in the specified directory
            $data['file'] = $files->storeAs('assets/file-arsip/' . $data['division_code'] . '/' . $data['number_container'], $fullname);

            if ($data['file'] === false) {
                // Handle the error
                alert()->error('Error', 'Failed to upload file');
                return redirect()->back()->withInput();
            }

            // hapus file
            if ($path_file != null || $path_file != '') {
                Storage::delete($path_file);
            }
        }

        $archiveContainer->update($data);

        alert()->success('Success', 'Data successfully added');
        return redirect()->back()->withInput();



        // try {
        //     // Retrieve form data
        //     $data = $request->all();

        //     $path_file = $archiveContainer['file'];

        //     // Process file upload
        //     if ($request->hasFile('file')) {
        //         $files = $request->file('file');

        //         if ($files->getClientOriginalExtension() == 'pdf') {
        //             // Specify the path to pdftotext executable
        //             // $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';

        //             // // Use spatie/pdf-to-text to extract text from the PDF
        //             // $text = (new Pdf($pdftotextPath))
        //             //     ->setPdf($files->getRealPath())
        //             //     ->text();
        //             $text = (new Pdf())
        //                 ->setPdf($files->getRealPath())
        //                 ->text();
        //             // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
        //             // $filteredText = preg_replace("/[^a-zA-Z0-9 ,.\/=()]/", "", $text);
        //             $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

        //             // Get the first 100 characters from the filtered text
        //             $first200Chars = substr($filteredText, 0, 180);

        //             // Store the filtered text in the 'content_file' column
        //             $data['content_file'] = $filteredText;
        //         }

        //         $file = $files->getClientOriginalName();
        //         $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first200Chars . ' )' . '-' . Str::random(5);
        //         $extension = $files->getClientOriginalExtension();
        //         $fullname = $basename . '.' . $extension;

        //         // Store the file in the specified directory
        //         $data['file'] = $files->storeAs('assets/file-arsip/' . $data['subseries'] . '/' . $data['number_container'], $fullname);

        //         if ($path_file != null || $path_file != '') {
        //             Storage::delete($path_file);
        //         }

        //         if ($data['file'] === false) {
        //             // Handle the error
        //             alert()->error('Error', 'Failed to upload file');
        //             return redirect()->back()->withInput();
        //         }
        //     } else {
        //         $data['file'] = $path_file;
        //     }
        //     // else {
        //     //     // Handle the case where no file was uploaded
        //     //     // You may want to return an error message or redirect back to the form
        //     //     alert()->error('Error', 'No file uploaded. Please upload a file.');
        //     //     return redirect()->back()->withInput();
        //     // }

        //     // Start a database transaction
        //     DB::beginTransaction();

        //     try {
        //         // Store to database
        //         // get all request from frontsite

        //         $archiveContainer->update($data);


        //         // Commit the transaction if everything is successful
        //         DB::commit();

        //         alert()->success('Success', 'Data successfully Updated');
        //         // return redirect()->back()->withInput();
        //         return redirect()->route('backsite.archive-container.index');
        //     } catch (\Exception $e) {
        //         // Rollback the transaction in case of an error
        //         DB::rollBack();

        //         // Log the error
        //         Log::error("Database transaction error: " . $e->getMessage());

        //         // Provide feedback to the user or redirect with an error message
        //         alert()->error('Error', 'Failed to add data. Please try again.');
        //         return redirect()->back()->withInput();
        //     }
        // } catch (\Exception $e) {
        //     // Log the error
        //     Log::error("File upload or text extraction error: " . $e->getMessage());

        //     // Provide feedback to the user or redirect with an error message
        //     alert()->error('Error', 'Failed to process the file. Please try again.');
        //     return redirect()->back()->withInput();
        // }
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

        // cari old photo
        $path_file = $archiveContainer['file'];

        // hapus file
        if ($path_file != null || $path_file != '') {
            Storage::delete($path_file);
        }
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

    public function showBarcode($id)
    {
        // $decrypt_id = decrypt($id);
        // $barang = Barang::find($decrypt_id);
        $archiveContainer = ArchiveContainer::find($id);
        $qr = QrCode::size(170)->style('round')->margin(1)->generate(route('qr-archive', $id));
        return view('components.qr-code.archive-qr.show-barcode-archive', compact('archiveContainer', 'qr'));
    }

    public function detailArchive($id)
    {
        // $id = $request->id;
        // $decrypt_id = decrypt($id);
        $archiveContainers = ArchiveContainer::findOrFail($id);
        return view('components.qr-code.archive-qr.detail-qr-archive', compact('archiveContainers'));
    }
}
