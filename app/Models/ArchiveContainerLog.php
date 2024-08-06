<?php

namespace App\Models;

use App\Models\TransactionArchive\FolderDivision\FolderItemFile;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionArchive\Archive\ArchiveContainer;

class ArchiveContainerLog extends Model
{
    use HasFactory;
    use LogsActivity;
    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('archive-log'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        if ($this->archiveContainer) {
            return "{$this->archiveContainer->number_app} been {$this->action}";
        } else {
            $fileName = basename($this->folderFile->file);
            return "{$fileName} has been {$this->action}";
        }

    }

    protected $fillable = [
        'archive_container_id', 'folder_file_id', 'user_id', 'ip_address', 'action',
    ];

    public function archiveContainer()
    {
        return $this->belongsTo(ArchiveContainer::class);
    }
    public function folderFile()
    {
        return $this->belongsTo(FolderItemFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
