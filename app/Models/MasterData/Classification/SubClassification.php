<?php

namespace App\Models\MasterData\Classification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubClassification extends Model
{
    use HasFactory;

    protected $table = 'classification_subs';
    protected $fillable = [
        'main_classification_id',
        'code',
        'name',
        'description',
    ];

    public function main_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainClassification::class, 'main_classification_id');
    }
}
