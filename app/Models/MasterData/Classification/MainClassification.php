<?php

namespace App\Models\MasterData\Classification;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\Retention\RetentionArchives;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainClassification extends Model
{
    use HasFactory;

    protected $table = 'classification_mains';
    protected $fillable = [
        'company_id',
        'division_id',
        'code',
        'name',
        'description',
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
