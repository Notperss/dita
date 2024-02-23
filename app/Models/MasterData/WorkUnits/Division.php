<?php

namespace App\Models\MasterData\WorkUnits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

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
}