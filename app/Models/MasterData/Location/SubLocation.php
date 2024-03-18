<?php

namespace App\Models\MasterData\Location;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubLocation extends Model
{
    use HasFactory;

    protected $table = 'location_subs';
    protected $fillable = [
        'main_location_id',
        'company_id',
        'name',
    ];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function mainLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainLocation::class, 'main_location_id');
    }

    public function detailLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(DetailLocation::class, 'location_id', 'id');
    }
}
