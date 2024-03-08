<?php

namespace App\Models\MasterData\Company;

use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\DetailUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'description',
    ];

    public function detail_user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(DetailUser::class, 'company_id');
    }
}
