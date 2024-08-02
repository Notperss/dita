<?php

namespace App\Models\TransactionArchive\FolderDivision;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolderItemFile extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    protected static $recordEvents = ['deleted', 'created'];
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'number',
                'date',
                'description',
                'file',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('folder-file'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        return "folder file has been {$eventName}";
    }


    protected $fillable = [
        'folder_id',
        'company_id',
        'division_id',
        'number',
        'date',
        'description',
        'file',
        'is_lock',
    ];

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

    public function folder()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(FolderDivision::class, 'folder_id');
    }
}
