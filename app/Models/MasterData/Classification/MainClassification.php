<?php

namespace App\Models\MasterData\Classification;

use App\Models\MasterData\Retention\RetentionArchives;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainClassification extends Model
{
    use HasFactory;

    protected $table = 'classification_mains';
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function sub_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(SubClassification::class, 'main_classification_id', 'id');
    }
    public function retention()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(RetentionArchives::class, 'main_classification_id', 'id');
    }
}
