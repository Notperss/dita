<?php

namespace App\Models\TransactionArchive\Archive;

use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveContainer extends Model
{
    use HasFactory;
    protected $fillable = [
        'division_id',//
        'number_container',//
        'main_location',//
        'sub_location',//
        'detail_location',//
        'description_location',//

        'main_classification_id',
        'sub_classification_id',
        'subseries',
        'period_active',
        'period_inactive',
        'expiration_active', //hidden
        'expiration_inactive', ///hidden
        'description_active',
        'description_inactive',
        'description_retention',


        'number_app',
        'number_catalog',
        'number_document',
        'number_archive',
        'regarding',
        'tag',
        'document_type',
        'archive_type',
        'amount',
        // 'section',
        'archive_in',
        'year',
        'file',
        'content_file',
    ];

    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }
}
