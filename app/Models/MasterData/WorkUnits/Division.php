<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionArchive\Archive\ArchiveContainer;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'code',
        'name',
    ];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Department::class, 'division_id', 'id');
    }
    public function section()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Section::class, 'division_id', 'id');
    }
    public function archive_container()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(ArchiveContainer::class, 'division_id', 'id');
    }
}
