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
        'user_id',
        'lending_id',
        'company_id',
        'archive_container_id',
        'status',
        'approval',
        'period',
        'type_document',
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
