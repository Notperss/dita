<?php

namespace App\Models\ManagementAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function detail_user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(DetailUser::class, 'type_user_id');
    }
}
