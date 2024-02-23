<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'department_id',
        'name',
    ];

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
