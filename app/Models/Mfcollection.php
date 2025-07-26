<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mfcollection extends Model
{
    protected $table = 'mfcollection';
    protected $primaryKey = 'MFCollectionID';
    public $incrementing = false;

    protected $fillable = [
        'MFCollectionID',
        'ClientCode',
        'TransCode',
        'BalanceDate',
        'TotalAmount',
    ];

    public function details()
    {
        return $this->hasMany(Mfcollectiondtl::class, 'MFCollectionID', 'MFCollectionID');
    }
}
