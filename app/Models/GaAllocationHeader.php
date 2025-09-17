<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAllocationHeader extends Model
{
    protected $table = 'gaallocationheader';
    protected $primaryKey = 'AutoID';   

    protected $fillable = [
        'AcctCode',
        'DivRef',
        'PatRef',
        'FolderKey',
        'Posted',
        'PostedDate',
        'User',
    ];
}
