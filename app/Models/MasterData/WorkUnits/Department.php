<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'division_id',
        'name',
    ];

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
