<?php

namespace App\Models\MasterData\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainLocation extends Model
{
    use HasFactory;

    protected $table = 'location_mains';
    protected $fillable = [
        'name',
    ];

    public function subLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(SubLocation::class, 'main_location_id', 'id');
    }

    public function detailLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(DetailLocation::class, 'location_id', 'id');
    }

    // public function container()
    // {
    //     // 2 parameter (path model, field foreign key)
    //     return $this->hasMany('App\Models\MasterData\Location\Location', 'location_id');
    // }
}
