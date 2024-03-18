<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'division_id',
        'company_id',
        'name',
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

    public function section()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Section::class, 'department_id', 'id');
    }
}
