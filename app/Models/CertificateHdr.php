<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateHdr extends Model
{
    protected $table = 'certificateshdr';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'FolderKey',
        'StartCertNumber',
        'Posted',
    ];

}
