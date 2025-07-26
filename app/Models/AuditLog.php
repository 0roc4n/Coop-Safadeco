<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'AuditDate',
        'UserID',
        'Action',
        'Remarks',
        'RecordType',
        'TransactionID',
        'UserOverride',
    ];
}
