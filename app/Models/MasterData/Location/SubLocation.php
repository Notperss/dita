<?php

namespace App\Models\MasterData\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocation extends Model
{
    use HasFactory;

    protected $table = 'location_subs';
    protected $fillable = [
        'main_location_id',
        'name',
    ];

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
