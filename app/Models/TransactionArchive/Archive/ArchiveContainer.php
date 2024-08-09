<?php

namespace App\Models\TransactionArchive\Archive;

use App\Models\ArchiveContainerLog;
use App\Models\MasterData\Location\ContainerLocation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\MasterData\Classification\MainClassification;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;

class ArchiveContainer extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'division_id',
                // 'company_id',
                'number_container',
                'main_location',
                'sub_location',
                'detail_location',
                'description_location',

                'main_classification_id',
                'sub_classification_id',
                // 'subseries',
                // 'period_active',
                // 'period_inactive',
                'expiration_active', //hidden
                'expiration_inactive', ///hidden
                // 'description_active',
                // 'description_inactive',
                // 'description_retention',

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
                // 'content_file',
                'status',
                'is_lock',
                'is_lend',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('archive'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        return "{$this->number_app} has been {$eventName}";
    }
    protected $fillable = [
        'division_id',
        'company_id',
        'location_container_id',
        'number_container',
        'main_location',
        'sub_location',
        'detail_location',
        'description_location',

        'main_classification_id',
        'sub_classification_id',
        // 'subseries',
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
        'status',
        'is_lock',
        'is_lend',
        'archive_status',
    ];

    protected $dates = ['deleted_at'];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function mainClassification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainClassification::class, 'main_classification_id');
    }
    public function subClassification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(SubClassification::class, 'sub_classification_id');
    }
    public function locationContainer()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(ContainerLocation::class, 'location_container_id');
    }

    public function lendingArchive()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(LendingArchive::class, 'archive_container_id', 'id');
    }
    public function archiveLogs()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(ArchiveContainerLog::class, 'archive_container_id', 'id');
    }

}
