<?php

namespace App\Models\MasterData\Classification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainClassification extends Model
{
    use HasFactory;

    protected $table = 'classification_mains';
    protected $fillable = [
        'name',
        'description',
    ];

    public function sub_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(SubClassification::class, 'main_classification_id', 'id');
    }
}
