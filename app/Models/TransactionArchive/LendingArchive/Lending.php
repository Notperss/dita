<?php

namespace App\Models\TransactionArchive\LendingArchive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lending_number',//
        'start_date',
        'end_date',
        'division',//
        'approval',//
        'description',//
    ];

    public function lendingArchive()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(LendingArchive::class, 'lending_id', 'id');
    }
}
