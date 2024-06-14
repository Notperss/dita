<?php

namespace App\Models\TransactionArchive\FolderDivision;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolderDivision extends Model
{
    use NodeTrait;
    use HasFactory;
    use LogsActivity;

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
                'name',
                'description',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('folder'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        return "folder has been {$eventName}";
    }

    protected $fillable = [
        'company_id',
        'division_id',
        'name',
        'description',
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

    public function folder_file()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(FolderItemFile::class, 'folder_id', 'id');
    }
}
