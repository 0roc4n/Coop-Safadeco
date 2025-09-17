<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankReconcillation extends Model
{
    protected $primaryKey = 'BankReconID';
    public $timestamps = false;

    protected $fillable = [
        'BankBal',
        'ReconDate',
        'AcctCode',
        'FolderKey',
    ];

    // Relationships
    public function account()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }

    public function folder()
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }
}
