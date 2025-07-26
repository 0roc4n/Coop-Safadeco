<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateDtl extends Model
{
    protected $table = 'certificatesdtl';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'CertNumber',
        'ClientCode',
        'ClientName',
        'Deposit',
        'Withdrawal',
        'PaidUpBalance',
        'Stocks',
        'FolderKey',
    ];

    
}
