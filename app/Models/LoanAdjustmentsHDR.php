<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanAdjustmentsHDR extends Model
{
    protected $primaryKey = 'AdjustHDRID';
    public $timestamps = true;

    protected $fillable = [
        'TransCode',
        'DateOfTran',
        'Remarks',
        'StatusCode',
        'FolderKey',
        'ClientCode',
    ];

    public function folder()
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }

    public function client()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
