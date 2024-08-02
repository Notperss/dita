<?php

namespace App\Http\Controllers\TransactionArchive\Archive;

use DateTime;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\ArchiveContainerLog;
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

            if (Gate::allows('super_admin')) {
                $archiveContainers = ArchiveContainer::with('division')->orderBy('created_at', 'desc');
            } else {
                $archiveContainers = ArchiveContainer::where('archive_containers.company_id', $company_id)->with('division', 'subClassification')->orderBy('created_at', 'desc');
            }

            return DataTables::of($archiveContainers)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $hiddenStatus = $item->status == 9 || $item->status == 10 || $item->is_lock ? 'hidden' : '';
                    return '
             <a href="#mymodal" data-remote="' . route('showBarcodeContainer', $item->id) . '" data-toggle="modal"
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
                       <a href="#mymodal" data-remote="' . route('archive-container.show', $item->id) . '" data-toggle="modal"
                        data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                         <i class="bi bi-eye"></i> Detail
                    </a>
                        <a class="dropdown-item"
                          href="' . route('archive-container.edit', $item->id) . '" ' . $hiddenStatus . '><i class="bi bi-pencil"></i> Edit</a>
                          
                        <a class="dropdown-item" onclick="showSweetAlert(' . $item->id . ')" ' . $hiddenStatus . '><i class="bi bi-x-lg"></i> Delete</a>

                         <a class="dropdown-item"
                          href="' . route('moveArchive', $item->id) . '" ' . $hiddenStatus . '><i class="bi bi-box-seam"></i> Pindah Container</a>
                      </div>
                    </div>
                  </div>
                  <form id="deleteForm_' . $item->id . '"
                    action="' . route('archive-container.destroy', encrypt($item->id)) . '"
                    method="POST">
                    ' . method_field('delete') . csrf_field() . '
                  </form>
                ';
                })->editColumn('lock', function ($item) {
                    if ($item->status == 1) {
                        if ($item->is_lock) {

                            if (auth()->user()->can('super_admin')) {
                                return '<a onclick="return confirm(\'Apakah kamu yakin akan membuka kunci arsip?\')" href="' . route('lock', $item->id) . '" class="btn btn-success btn-sm" title="buka kunci">
                                    <i class="bi bi-lock"></i>
                                    </a>';
                            } else {
                                return '<a onclick="alert(\'Hubungi Administrator untuk membuka kunci!\')" class="btn btn-success btn-sm" title="Arsip Terkunci">
                                    <i class="bi bi-lock"></i>
                                    </a>';
                            }
                        } else {
                            return '<a onclick="return confirm(\'Apakah kamu yakin akan mengunci arsip?\')" href="' . route('lock', $item->id) . '" class="btn btn-danger btn-sm" title="Arsip Terbuka">
                                <i class="bi bi-unlock"></i>
                                </a>';
                        }

                    } elseif ($item->status == 10) {
                        return '<a class="btn btn-danger btn-sm" title="Arsip Musnah">
                                <i class="bi bi-file-earmark-excel h6"></i></i>
                                </a>';
                    } else {
                        return '<a class="btn btn-secondary btn-sm" title="Arsip Dalam Transaksi">
                                <i class="bi bi-arrow-repeat"></i>
                                </a>';
                    }
                })
                ->rawColumns(['action', 'lock'])
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
        $request->validate([
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            'archive_in' => 'required|date',

            'number_app' => 'required|string|unique:archive_containers',
            'number_container' => 'required|string',
            'year' => 'required|string',

            // 'file' => 'required|file|mimes:pdf|max:290',
            'file' => 'file|mimes:pdf',
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

            //PDF TO TEXT
            // if ($files->getClientOriginalExtension() == 'pdf') {
            //     // Specify the path to pdftotext executable

            //     $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';
            //     // Use spatie/pdf-to-text to extract text from the PDF
            //     $text = (new Pdf($pdftotextPath))
            //         ->setPdf($files->getRealPath())
            //         ->text();

            //     // $text = (new Pdf())
            //     //     ->setPdf($files->getRealPath())
            //     //     ->text();

            //     // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
            //     $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

            //     // Get the first 100 characters from the filtered text
            //     // $first100Chars = substr($filteredText, 0, 100);

            //     // Store the filtered text in the 'content_file' column
            //     $data['content_file'] = $filteredText;
            // }

            $replaceInvalidCharacters = ['/', ':', '*', '?', '"', '<', '>', '|'];

            $numberApp = str_replace($replaceInvalidCharacters, '-', $data['number_app']);
            $tag = str_replace($replaceInvalidCharacters, '-', $data['tag']);
            $regarding = str_replace($replaceInvalidCharacters, '-', $data['regarding']);

            $file = $files->getClientOriginalName();
            // $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first100Chars . ' )' . '-' . Str::random(5);
            $basename = pathinfo($file, PATHINFO_FILENAME) . '_' . $numberApp . '_' . $tag . '_' . $regarding . '_' . Str::random(3);
            $extension = $files->getClientOriginalExtension();
            $fullname = $basename . '.' . $extension;

            // Check if the disk root directory exists
            $disk_root = config('filesystems.disks.d_drive.root');
            if (! file_exists($disk_root) || ! is_dir($disk_root)) {
                alert()->error('Error', 'Disk or path not found.');
                return redirect()->back()->withInput();
            }

            // Store the file in the specified directory
            $data['file'] = $files->storeAs('file-arsip/' . $data['division_code'] . '/' . $data['number_container'], $fullname, 'd_drive');

            if ($data['file'] === false) {
                // Handle the error
                alert()->error('Error', 'Failed to upload file');
                return redirect()->back()->withInput();
            }
        }

        $company_id = Auth::user()->company_id;

        if (isset($data['masa_aktif']) && is_numeric($data['masa_aktif'])) {
            // Add a specific number of years to the current date if dateArchive does not exist
            $years_to_add = $data['masa_aktif']; // Example: Number of years to add
            $current_date = new DateTime(); // Current date
            $current_date->modify("+$years_to_add year"); // Modify the date
            $future_date_active = $current_date->format('Y-m-d'); // Format the date
            // Set the default value
            $data['expiration_active'] = $future_date_active;
        } else {
            // Set expiration_active to 'permanent'
            $data['expiration_active'] = 'PERMANEN';
        }

        if (isset($data['masa_inaktif']) && is_numeric($data['masa_inaktif'])) {
            // Add a specific number of years to the active period date
            $years_to_add = $data['masa_inaktif']; // Example: Number of years to add
            // $active_date = new DateTime($data['expiration_active']); // Use the active period date
            $active_date = new DateTime($data['expiration_active']); // Use the active period date
            $active_date->modify("+$years_to_add year"); // Modify the date
            $future_date_inactive = $active_date->format('Y-m-d'); // Format the date
            // dd($future_date_inactive);

            // Set the default value
            $data['expiration_inactive'] = $future_date_inactive;
        } else {
            // Set expiration_active to 'permanent'
            $data['expiration_inactive'] = 'PERMANEN';
        }
        // Merge the company_id into the request data
        $requestData = array_merge($data, ['company_id' => $company_id]);
        // Store to database
        ArchiveContainer::create($requestData);

        alert()->success('Success', 'Data successfully added');
        return redirect()->back()->withInput();

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
        $mainClassifications = MainClassification::where('division_id', $archiveContainers->division_id)->orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('main_classification_id', $archiveContainers->main_classification_id)->get();
        $retentions = RetentionArchives::where('sub_classification_id', $archiveContainers->sub_classification_id)->get();
        // $divisions = Division::orderBy('id', 'asc')->get();
        // $sections = Section::orderBy('id', 'asc')->get();

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
            ));
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
            'main_classification_id' => 'required|string',
            'sub_classification_id' => 'required|string',
            'document_type' => 'required|string',
            'archive_type' => 'required|string',
            'archive_in' => 'required|date',
            'number_app' => [
                'required',
                'string',
                Rule::unique('archive_containers')->ignore($archiveContainer->id),
            ],
            // 'number_catalog' => 'required|string',
            // 'number_document' => 'required|string',
            'number_container' => 'required|string',
            'year' => 'required|string',

            // 'file' => 'required|file|mimes:pdf|max:290',
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

        $path_file = $archiveContainer['file'];
        // Process file upload only if a file is uploaded
        if ($request->hasFile('file')) {
            $files = $request->file('file');


            //PDF TO TEXT
            // if ($files->getClientOriginalExtension() == 'pdf') {

            //     // Microsoft
            //     // Specify the path to pdftotext executable
            //     $pdftotextPath = 'C:\Program Files\Git\mingw64\bin\pdftotext.exe';

            //     // Use spatie/pdf-to-text to extract text from the PDF
            //     $text = (new Pdf($pdftotextPath))
            //         ->setPdf($files->getRealPath())
            //         ->text();

            //     // // Linux
            //     // $text = (new Pdf())
            //     //     ->setPdf($files->getRealPath())
            //     //     ->text();

            //     // Filter out non-alphabetic characters, spaces, commas, dots, slashes, equal sign, parentheses, and numbers from the extracted text
            //     $filteredText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);

            //     // Get the first 100 characters from the filtered text
            //     // $first200Chars = substr($filteredText, 0, 180);

            //     // Store the filtered text in the 'content_file' column
            //     $data['content_file'] = $filteredText;
            // }


            $replaceInvalidCharacters = ['/', ':', '*', '?', '"', '<', '>', '|'];

            $numberApp = str_replace($replaceInvalidCharacters, '-', $data['number_app']);
            $tag = str_replace($replaceInvalidCharacters, '-', $data['tag']);
            $regarding = str_replace($replaceInvalidCharacters, '-', $data['regarding']);

            $file = $files->getClientOriginalName();
            // $basename = pathinfo($file, PATHINFO_FILENAME) . ' ( ' . $first200Chars . ' )' . '-' . Str::random(5);
            $extension = $files->getClientOriginalExtension();
            $basename = pathinfo($file, PATHINFO_FILENAME) . '_' . $numberApp . '_' . $tag . '_' . $regarding . '_' . Str::random(3);
            $fullname = $basename . '.' . $extension;

            // Check if the disk root directory exists
            $disk_root = config('filesystems.disks.d_drive.root');
            if (! file_exists($disk_root) || ! is_dir($disk_root)) {
                alert()->error('Error', 'Disk or path not found.');
                return redirect()->back()->withInput();
            }

            // Store the file in the specified directory
            $data['file'] = $files->storeAs('file-arsip/' . $data['division_code'] . '/' . $data['number_container'], $fullname, 'd_drive');

            if ($data['file'] === false) {
                // Handle the error
                alert()->error('Error', 'Failed to upload file');
                return redirect()->back()->withInput();
            }

            // hapus file
            if ($path_file != null || $path_file != '') {
                Storage::disk('d_drive')->delete($path_file);
            }
        }

        if (isset($data['masa_aktif']) && is_numeric($data['masa_aktif'])) {
            // Add a specific number of years to the current date if dateArchive does not exist
            $years_to_add = $data['masa_aktif']; // Example: Number of years to add
            $current_date = new DateTime(); // Current date
            $current_date->modify("+$years_to_add year"); // Modify the date
            $future_date_active = $current_date->format('Y-m-d'); // Format the date
            // Set the default value
            $data['expiration_active'] = $future_date_active;
        } else {
            // Set expiration_active to 'permanent'
            $data['expiration_active'] = 'PERMANEN';
        }

        if (isset($data['masa_inaktif']) && is_numeric($data['masa_inaktif'])) {
            // Add a specific number of years to the active period date
            $years_to_add = $data['masa_inaktif']; // Example: Number of years to add
            // $active_date = new DateTime($data['expiration_active']); // Use the active period date
            $active_date = new DateTime($data['expiration_active']); // Use the active period date
            $active_date->modify("+$years_to_add year"); // Modify the date
            $future_date_inactive = $active_date->format('Y-m-d'); // Format the date
            // dd($future_date_inactive);

            // Set the default value
            $data['expiration_inactive'] = $future_date_inactive;
        } else {
            // Set expiration_active to 'permanent'
            $data['expiration_inactive'] = 'PERMANEN';
        }

        $archiveContainer->update($data);

        alert()->success('Success', 'Data successfully added');
        return redirect()->route('archive-container.index');
        // return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // deskripsi id
        $decrypt_id = decrypt($id);
        $archiveContainer = ArchiveContainer::find($decrypt_id);
        // dd($archiveContainer);

        // // cari old photo
        // $path_file = $archiveContainer['file'];

        // // hapus file
        // if ($path_file != null || $path_file != '') {
        //     Storage::disk('d_drive')->delete($path_file);
        // }
        // hapus location
        $archiveContainer->delete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    // public function form_upload(Request $request)
    // {
    //     if ($request->ajax()) {

    //         $archiveContainers = ArchiveContainer::orderBy('id', 'asc')->get();
    //         $divisions = Division::orderBy('id', 'asc')->get();
    //         $mainClassifications = MainClassification::orderBy('name', 'asc')->get();
    //         // $divisions = Division::orderBy('id', 'asc')->get();
    //         $sections = Section::orderBy('id', 'asc')->get();
    //         $data = [
    //             'archiveContainers' => $archiveContainers,
    //             'divisions' => $divisions,
    //             'sections' => $sections,
    //             'mainClassifications' => $mainClassifications,
    //         ];

    //         $msg = [
    //             'data' => view('pages.transaction-archive.archive-container.form-upload', $data)->render(),
    //         ];

    //         return response()->json($msg);
    //     }
    // }

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
        if (Gate::allows('super_admin')) {
            $detailNumbers = ArchiveContainer::where('number_container', $numberId)->orderBy('created_at', 'desc')->get();
        } else {
            $detailNumbers = ArchiveContainer::where('number_container', $numberId)->where('company_id', auth()->user()->company_id)->orderBy('created_at', 'desc')->get();
        }
        // Extracting relevant data and adding 'name' property
        $formattedDetailLocations = $detailNumbers->map(function ($detailNumber) {
            return [
                'id' => $detailNumber->id,
                'number_container' => $detailNumber->number_container,
                'number_document' => $detailNumber->number_document, // Assuming 'name' is a property in the 'mainLocation' model
                'regarding' => $detailNumber->regarding, // Assuming 'name' is a property in the 'mainLocation' model
                'archive_type' => $detailNumber->archive_type, // Assuming 'name' is a property in the 'mainLocation' model
            ];
        });

        return response()->json($formattedDetailLocations);
    }

    public function showBarcode($id)
    {
        // $decrypt_id = decrypt($id);
        // $barang = Barang::find($decrypt_id);
        // $archiveContainer = ArchiveContainer::find($id);
        // $qr = QrCode::size(170)->style('round')->margin(1)->generate(route('qr-archive', $id));
        // return view('components.qr-code.archive-qr.show-barcode-archive', compact('archiveContainer', 'qr'));
        $archiveContainer = ArchiveContainer::find($id);
        $qr = QrCode::size(150)->style('round')->margin(1)->generate($archiveContainer->number_app);
        return view('components.qr-code.archive-qr.show-barcode-archive', compact('archiveContainer', 'qr'));
    }

    public function detailArchive($id)
    {
        // $id = $request->id;
        // $decrypt_id = decrypt($id);
        $archiveContainers = ArchiveContainer::findOrFail($id);
        return view('components.qr-code.archive-qr.detail-qr-archive', compact('archiveContainers'));
    }

    public function dataArchive(Request $request)
    {
        // if (! Gate::allows('archive_container_index')) {
        //     abort(403);
        // }

        if (request()->ajax()) {

            $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user

            if (Gate::allows('super_admin')) {
                // Super admin: can view all archive containers
                $archiveContainers = ArchiveContainer::with('division')->where('status', 1)->orderBy('created_at', 'desc');
            } else {
                // Non-super admin: view archive containers limited to their company
                $archiveContainers = ArchiveContainer::where('company_id', $company_id)->where('status', 1)
                    ->with('division')
                    ->orderBy('created_at', 'desc');
            }

            // Apply year filter if present
            if ($request->has('year') && ! empty($request->year)) {
                $archiveContainers->where('year', $request->year);
            }
            // Apply regarding filter if present
            if ($request->has('regarding') && ! empty($request->regarding)) {
                $archiveContainers->where('regarding', 'like', '%' . $request->regarding . '%');
            }
            // Apply catalog filter if present
            if ($request->has('catalog') && ! empty($request->catalog)) {
                $archiveContainers->where('number_catalog', 'like', '%' . $request->catalog . '%');
            }
            // Apply document filter if present
            if ($request->has('document') && ! empty($request->document)) {
                $archiveContainers->where('number_document', 'like', '%' . $request->document . '%');
            }
            // Apply archive filter if present
            if ($request->has('archive') && ! empty($request->archive)) {
                $archiveContainers->where('number_archive', 'like', '%' . $request->archive . '%');
            }
            // Apply tag filter if present
            if ($request->has('tag') && ! empty($request->tag)) {
                $archiveContainers->where('tag', 'like', '%' . $request->tag . '%');
            }
            // Apply type filter if present
            if ($request->has('type') && ! empty($request->type)) {
                $archiveContainers->where('archive_type', 'like', $request->type);
            }
            // Apply division filter if present
            if ($request->has('division') && ! empty($request->division)) {
                $archiveContainers->whereHas('division', function ($query) use ($request) {
                    $query->where('code', 'like', '%' . $request->division . '%');
                });
            }

            return DataTables::of($archiveContainers)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                <div class="btn-group mb-1">
                    <div class="dropdown">
                        <button class="btn btn-primary btn dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="#mymodal" data-remote="' . route('archive-container.show', $item->id) . '" data-toggle="modal"
                            data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
                ';
                })
                ->rawColumns(['action',])
                ->toJson();
        }
        $divisions = Division::orderBy('name', 'asc')->get();

        // $archiveContainers = ArchiveContainer::orderBy('id', 'asc')->get();
        return view('pages.transaction-archive.archive-container.data-archive', compact('divisions'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            // Perform the search query
            $results = ArchiveContainer::where('number_app', 'LIKE', "{$query}")
                // ->orWhere('description', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $results = collect();
        }

        // Return the view with the search results
        return view('components.qr-code.archive-qr.detail-qr-archive', compact('results'));
    }

    public function deletedArchives()
    {
        if (! Gate::allows('super_admin')) {
            abort(403);
        }
        $deletedArchives = ArchiveContainer::onlyTrashed()->get();
        return view('pages.transaction-archive.archive-container.deleted-archives', compact('deletedArchives'));
    }
    public function restoreArchives($id)
    {
        if (! Gate::allows('super_admin')) {
            abort(403);
        }
        $deletedArchives = ArchiveContainer::withTrashed()->find($id);
        if ($deletedArchives) {
            $deletedArchives->restore();
            alert()->success('Success', 'Data restored successfully');
            return back();
        } else {
            alert()->error('Error', 'Data not found');
            return back();
        }
    }
    public function forceDelete($id)
    {
        if (! Gate::allows('super_admin')) {
            abort(403);
        }
        // $decryptId = decrypt($id);
        // $deletedArchives = ArchiveContainer::withTrashed()->find($decryptId);
        $deletedArchives = ArchiveContainer::withTrashed()->find($id);

        if ($deletedArchives) {
            $deletedArchives->forceDelete();
            // Log the force delete action
            activity('archive')
                ->performedOn($deletedArchives)
                ->causedBy(auth()->user())
                ->log('Force deleted a data archive');
            alert()->success('Success', 'Data permanently deleted successfully');
            return back();
        } else {
            alert()->error('Error', 'Data not found');
            return back();
        }
    }

    public function viewFile($id)
    {
        // Find the archive container or fail
        $archiveContainer = ArchiveContainer::findOrFail($id);

        // Log the view action
        ArchiveContainerLog::create([
            'archive_container_id' => $archiveContainer->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'action' => 'viewed',
        ]);

        // Define the disk to use
        $disk = Storage::disk('d_drive');

        // Check if the file exists
        if (! $disk->exists($archiveContainer->file)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Get the file path
        $filePath = $disk->path($archiveContainer->file);

        // Return the file
        return response()->file($filePath);
    }

    public function downloadFile($id)
    {
        $archiveContainer = ArchiveContainer::findOrFail($id);

        // Increment downloads
        // $archiveContainer->increment('downloads');

        // Log the download action
        ArchiveContainerLog::create([
            'archive_container_id' => $archiveContainer->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'action' => 'download',
        ]);

        // Check if the file exists in storage
        $filePath = Storage::disk('d_drive')->path($archiveContainer->file);
        if (! Storage::disk('d_drive')->exists($archiveContainer->file)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Return the file
        return response()->file($filePath);
    }

    public function lock($id)
    {
        $archiveContainer = ArchiveContainer::find($id);
        if ($archiveContainer) {
            if ($archiveContainer->is_lock) {
                $archiveContainer->is_lock = false;
                alert()->success('Success', 'Arsip Terbuka!');
            } else {
                $archiveContainer->is_lock = true;
                alert()->success('Success', 'Arsip Terkunci!');
            }
        } else {
            alert()->error('Error', 'Gagal Melakukan Eksekusi!');
            return redirect()->back();
        }

        // dd($archiveContainer->is_lock);

        $archiveContainer->save();
        return redirect()->back();
    }

    public function moveArchive($id)
    {
        $company_id = auth()->user()->company_id; // Assuming the company_id is associated with the authenticated user

        $archiveContainers = ArchiveContainer::find($id);
        $divisions = Division::where('company_id', $company_id)->orderBy('id', 'asc')->get();
        $locationContainers = ContainerLocation::where('division_id', $archiveContainers->division_id)->orderBy('id', 'asc')->get();
        $mainClassifications = MainClassification::where('division_id', $archiveContainers->division_id)->orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('main_classification_id', $archiveContainers->main_classification_id)->get();

        $filepath = storage_path($archiveContainers->file);
        $fileName = basename($filepath);
        return view('pages.transaction-archive.archive-container.move-document', compact(
            'archiveContainers',
            'locationContainers',
            'divisions',
            'mainClassifications',
            'subClassifications',
            'fileName',
        ));
    }

    public function movingArchive($id, Request $request)
    {
        $archiveContainer = ArchiveContainer::find($id);

        $container = $request->all();

        if ($container) {
            // $archiveContainer->number_container = $container;
            $archiveContainer->update($container);
            alert()->success('Success', 'Arsip Dipindahkan!');
        } else {
            alert()->error('Error', 'Gagal Melakukan Eksekusi!');
            return redirect()->back();
        }

        // dd($request->number_container);

        // $archiveContainer->save();
        return redirect()->back();
    }
}
