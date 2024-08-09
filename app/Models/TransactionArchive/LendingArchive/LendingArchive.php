<?php

namespace App\Models\TransactionArchive\LendingArchive;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LendingArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lending_id',
        'company_id',
        'division_id',
        'archive_container_id',
        'status',
        'is_approve',
        'damaged_status',
        'file',
        'period',
        'document_type',
        'has_finished',
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
    public function user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(User::class, 'user_id');
    }
    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }
}
