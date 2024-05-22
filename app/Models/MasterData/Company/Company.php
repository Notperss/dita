<?php

namespace App\Models\MasterData\Company;

use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\DetailUser;
use App\Models\MasterData\WorkUnits\Division;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'description',
    ];

    public function user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(User::class, 'company_id');
    }
    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Division::class, 'company_id');
    }
}
