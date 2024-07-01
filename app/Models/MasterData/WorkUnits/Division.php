<?php

namespace App\Models\MasterData\WorkUnits;

use App\Models\MasterData\Classification\MainClassification;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionArchive\Archive\ArchiveContainer;
use App\Models\TransactionArchive\LendingArchive\LendingArchive;
use App\Models\User;

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
    public function user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(User::class, 'division_id', 'id');
    }
    public function main_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(MainClassification::class, 'division_id', 'id');
    }
    public function lendingArchive()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(LendingArchive::class, 'division_id', 'id');
    }
}
