<?php

namespace App\Models\TransactionArchive\FolderDivision;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolderItemFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_item_id',
        'folder_id',
        'company_id',
        'division_id',
        'file',
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
    public function folder_item()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(FolderItem::class, 'folder_item_id');
    }
}
