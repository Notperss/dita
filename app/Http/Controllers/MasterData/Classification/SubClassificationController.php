<?php

namespace App\Http\Controllers\MasterData\Classification;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\MasterData\Classification\MainClassification;

class SubClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('sub_classification_index')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        // $subClassifications = SubClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        $subClassifications = SubClassification::where('classification_subs.company_id', $company_id)->leftJoin('classification_mains', 'classification_subs.main_classification_id', '=', 'classification_mains.id')
            ->select('classification_subs.*')
            ->orderBy('classification_mains.name')
            ->orderBy('classification_subs.name', 'asc')
            ->get();

        return view('pages.master-data.classification.sub-classification.index', compact('subClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_id = auth()->user()->company_id;

        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return view('pages.master-data.classification.sub-classification.create', compact('mainClassifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sub_classification_create')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            // 'code' => ['required', 'max:255',],
            'document_type' => ['required', 'max:255',],
            'period_active' => ['required', 'max:255',],
            'period_inactive' => ['required', 'max:255',],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Sub Klasifikasi harus diisi.',
            'name.max' => 'Nama Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'main_classification_id.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Sub Klasifikasi harus diisi.',
            'document_type.required' => 'Tipe Dokumen harus diisi.',
            'period_active.required' => 'Masa Aktif harus diisi.',
            'period_inactive.required' => 'Masa Inaktif harus diisi.',
            'code.max' => 'Kode Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Sub Klasifikasi sudah digunakan.',

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
        SubClassification::create($requestData);

        alert()->success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('sub-classification.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(SubClassification $subClassification)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('sub_classification_edit')) {
            abort(403);
        }
        $company_id = auth()->user()->company_id;

        $subClassifications = SubClassification::find($id);
        $mainClassifications = MainClassification::where('company_id', $company_id)->orderBy('name', 'asc')->get();

        return view('pages.master-data.classification.sub-classification.edit', compact('subClassifications', 'mainClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubClassification $subClassification)
    {
        if (! Gate::allows('sub_classification_update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'main_classification_id' => ['required', 'max:255'],
            // 'code' => ['required', 'max:255',],

            // Add other validation rules as needed
        ], [
            'name.required' => 'Nama Sub Klasifikasi harus diisi.',
            'name.max' => 'Nama Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'main_classification_id.required' => 'Nama Klasifikasi harus diisi.',
            'main_classification_id.max' => 'Nama Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode Sub Klasifikasi harus diisi.',
            'code.max' => 'Kode Sub Klasifikasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode Sub Klasifikasi sudah digunakan.',

            // Add custom error messages for other rules
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get all request from frontsite
        $data = $request->all();

        $archiveContainers = ArchiveContainer::where('sub_classification_id', $subClassification->id)->get();


        // Set the new expiration_active value
        foreach ($archiveContainers as $archive_active) {
            $current_date = ($archive_active->created_at)->format('Y-m-d');

            if (isset($data['period_active']) && is_numeric($data['period_active'])) {
                // Ensure $subClassification->period_active is numeric
                $old_years_to_add_active = (int) $subClassification->period_active; // Convert to integer

                if ($archive_active->expiration_active == "PERMANEN") {
                    $archive_active->expiration_active = $current_date;
                    $archive_active->save();
                    $old_current_date_active = new DateTime($current_date);
                } else {
                    $old_current_date_active = new DateTime($archive_active->expiration_active);
                }

                // Ensure $old_years_to_add_active is numeric before modifying
                if (is_numeric($old_years_to_add_active)) {
                    // Subtract old years to get the initial date
                    $old_current_date_active->modify("-$old_years_to_add_active year"); // Modify the date
                    $future_date_active = $old_current_date_active->format('Y-m-d'); // Format the date

                    // Calculate the new future date by adding the active period
                    $new_years_to_add_active = (int) $data['period_active']; // Convert to integer
                    if (is_numeric($new_years_to_add_active)) {
                        $current_date_active = new DateTime($future_date_active); // Current date
                        $current_date_active->modify("+$new_years_to_add_active year"); // Modify the date
                        $new_future_date_active = $current_date_active->format('Y-m-d'); // Format the date

                        $archive_active->expiration_active = $new_future_date_active;
                    } else {
                        // Handle invalid new_years_to_add_active
                        $archive_active->expiration_active = 'PERMANEN';
                    }
                } else {
                    // Handle invalid old_years_to_add_active
                    $archive_active->expiration_active = 'PERMANEN';
                }
            } else {
                // Set expiration_active to 'PERMANEN'
                $archive_active->expiration_active = 'PERMANEN';
            }
            // Save the updated archive record
            $archive_active->save();
        }

        // Set the new expiration_inactive value
        foreach ($archiveContainers as $archive_inactive) {
            if (isset($data['period_inactive']) && is_numeric($data['period_inactive'])) {
                // Ensure $subClassification->period_inactive and $subClassification->period_active are numeric
                $old_years_to_add = (int) $subClassification->period_inactive + (int) $subClassification->period_active; // Convert to integer

                if ($archive_inactive->expiration_inactive == "PERMANEN") {
                    $archive_inactive->expiration_inactive = $current_date;
                    $archive_inactive->save();
                    $old_current_date_inactive = new DateTime($current_date);
                } else {
                    $old_current_date_inactive = new DateTime($archive_inactive->expiration_inactive);
                }

                // Ensure $old_years_to_add is numeric before modifying
                if (is_numeric($old_years_to_add)) {
                    // Subtract old years to get the initial date
                    $old_current_date_inactive->modify("-$old_years_to_add year");
                    $future_date_inactive = $old_current_date_inactive->format('Y-m-d');

                    // Calculate the new future date by adding the active and inactive periods
                    $years_to_add = (int) $data['period_inactive'] + (int) $data['period_active']; // Convert to integer
                    if (is_numeric($years_to_add)) {
                        $current_date_inactive = new DateTime($future_date_inactive);
                        $current_date_inactive->modify("+$years_to_add year");
                        $new_future_date_inactive = $current_date_inactive->format('Y-m-d');

                        $archive_inactive->expiration_inactive = $new_future_date_inactive;
                    } else {
                        // Handle invalid years_to_add
                        $archive_inactive->expiration_inactive = 'PERMANEN';
                    }
                } else {
                    // Handle invalid old_years_to_add
                    $archive_inactive->expiration_inactive = 'PERMANEN';
                }
            } else {
                // Set expiration_inactive to 'PERMANEN' if period_inactive is not provided or not numeric
                $archive_inactive->expiration_inactive = 'PERMANEN';
            }
            // Save the updated archive record
            $archive_inactive->save();
        }

        $subClassification->update($data);

        alert()->success('Sukses', 'Data berhasil di ubah');
        return redirect()->route('sub-classification.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('sub_classification_destroy')) {
            abort(403);
        }
        // deskripsi id
        $decrypt_id = decrypt($id);
        $subClassification = SubClassification::find($decrypt_id);

        // hapus location
        $subClassification->forceDelete();

        alert()->success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}
