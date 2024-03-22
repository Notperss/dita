<?php

namespace App\Models\TransactionArchive\LendingArchive;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LendingArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'lending_id',
        'archive_container_id',
        'status',
        'approval',
    ];

    public function lending()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Lending::class, 'lending_id');
    }
    public function archiveContainer()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(ArchiveContainer::class, 'archive_container_id');
    }
}
