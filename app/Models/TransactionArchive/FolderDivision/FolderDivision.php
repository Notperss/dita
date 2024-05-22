<?php

namespace App\Models\TransactionArchive\FolderDivision;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterData\Company\Company;
use App\Models\MasterData\WorkUnits\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolderDivision extends Model
{
    use NodeTrait;
    use HasFactory;

    protected $fillable = [
        'company_id',
        'division_id',
        'name',
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

    public function folder_item()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(FolderItem::class, 'folder_id', 'id');
    }
    public function folder_file()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(FolderItemFile::class, 'folder_id', 'id');
    }
}
