<?php

namespace App\Models\MasterData\Classification;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\Retention\RetentionArchives;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubClassification extends Model
{
    use HasFactory;

    protected $table = 'classification_subs';
    protected $fillable = [
        'main_classification_id',
        'company_id',
        'code',
        'name',
        'document_type',
        'period_active',
        'description_active',
        'period_inactive',
        'description_inactive',
        'description',
    ];
    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function main_classification()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainClassification::class, 'main_classification_id');
    }

    public function retention()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(RetentionArchives::class, 'sub_classification_id', 'id');
    }
}
