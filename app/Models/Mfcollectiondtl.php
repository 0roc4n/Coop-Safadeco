<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mfcollectiondtl extends Model
{
    protected $table = 'mfcollectiondtl';
    protected $primaryKey = 'MFCollectionDtlID';
    public $incrementing = false;

    protected $fillable = [
        'MFCollectionDtlID',
        'MFCollectionID',
        'ClientCode',
        'Balance',
        'Amount',
    ];

    public function header()
    {
        return $this->belongsTo(Mfcollection::class, 'MFCollectionID', 'MFCollectionID');
    }
}
