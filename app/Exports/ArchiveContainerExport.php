<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Employee\Employee;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ArchiveContainerExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $numberBox;
    protected $division;

    public function __construct($startDate, $endDate, $numberBox, $division)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->numberBox = $numberBox;
        $this->division = $division;
    }

    public function view(): View
    {
        // dd($this->numberBox);
        $archiveContainers = ArchiveContainer::with([
            'division',
            'locationContainer.mainLocation',
            'locationContainer.subLocation',
            'mainClassification',
            'subClassification',
        ])
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('archive_in', [$this->startDate, $this->endDate]);
            })
            ->when($this->numberBox, function ($query) {
                $query->where('location_container_id', $this->numberBox);
            })
            ->when($this->division, function ($query) {
                $query->where('division_id', $this->division);
            })
            // ->whereNotNull('nik')
            ->latest()
            ->get();

        return view('pages.transaction-archive.archive-container.export', compact('archiveContainers'));
    }

}
