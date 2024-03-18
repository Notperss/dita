<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'department_id',
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
    public function department()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Department::class, 'department_id');
    }
}
