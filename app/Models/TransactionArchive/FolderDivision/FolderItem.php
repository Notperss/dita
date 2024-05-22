<?php

namespace App\Models\TransactionArchive\FolderDivision;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'company_id',
        'division_id',
        'name',
        'number',
        'date',
        'description',
        'description',
    ];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function folder()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(FolderDivision::class, 'folder_id');
    }

    public function folder_file()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(FolderItemFile::class, 'folder_item_id', 'id');
    }
}
