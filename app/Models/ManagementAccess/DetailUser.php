<?php

namespace App\Models\ManagementAccess;

use App\Models\MasterData\Company\Company;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_user_id',
        'company_id',
        'nik',
        'status',
        'profile_photo_path',
    ];

    public function company()
    {
        // 3 parameter (path model, field foreign key, field primary key from table hasMany/hasOne)
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function type_user()
    {
        // 3 parameter (path model, field foreign key, field primary key from table hasMany/hasOne)
        return $this->belongsTo(TypeUser::class, 'type_user_id', 'id');
    }

    public function user()
    {
        // 3 parameter (path model, field foreign key, field primary key from table hasMany/hasOne)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
