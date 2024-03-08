<?php

namespace App\Models\MasterData\Retention;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MasterData\Classification\SubClassification;
use App\Models\MasterData\Classification\MainClassification;

class RetentionArchives extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_classification_id',
        'sub_classification_id',
        'sub_series',
        'period_active',
        'description_active',
        'period_inactive',
        'description_inactive',
        'description',
    ];

    public function main_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainClassification::class, 'main_classification_id');
    }

    public function sub_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(SubClassification::class, 'sub_classification_id');
    }

}
