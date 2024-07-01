<?php

namespace App\Models\TransactionArchive\LendingArchive;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_id',
        'division_id',//
        'lending_number',//
        'start_date',
        'end_date',
        'status',//
        'description',//
    ];

    public function lendingArchive()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(LendingArchive::class, 'lending_id', 'id');
    }
    public function user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Fungsi untuk menghasilkan nomor peminjaman arsip dengan format PA-YYYY-MM-NNN
    public static function generateLendingNumber()
    {
        // Mendapatkan tahun saat ini
        $year = now()->format('Y');

        // Mendapatkan bulan saat ini dalam format dua digit (01 untuk Januari, 02 untuk Februari, dst.)
        $month = now()->format('m');

        // Mendapatkan nomor urut berikutnya dari database atau sumber data lainnya
        // Anda bisa menyesuaikan dengan logika aplikasi Anda untuk mendapatkan nomor urut berikutnya

        // Misalnya, mendapatkan nomor urut terakhir dari database
        $nextNumber = (self::orderBy('id', 'desc')->value('lending_number'))
            ? intval(substr(self::orderBy('id', 'desc')->value('lending_number'), -3)) + 1
            : 1;

        // Format nomor peminjaman dengan menggunakan sprintf untuk menghasilkan nomor dengan leading zeros
        return sprintf('PA-%s-%s-%03d', $year, $month, $nextNumber);
    }

}
