<?php

namespace App\Models\MasterData\Location;

use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerLocation extends Model
{
    use HasFactory;
    protected $table = 'location_containers';
    protected $fillable = [
        'main_location_id',
        'sub_location_id',
        'detail_location_id',
        'division_id',
        'number_container',
        'description',
    ];

    public function mainLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(MainLocation::class, 'main_location_id');
    }
    public function subLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(SubLocation::class, 'sub_location_id');
    }
    public function detailLocation()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(DetailLocation::class, 'detail_location_id');
    }
    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }

}
