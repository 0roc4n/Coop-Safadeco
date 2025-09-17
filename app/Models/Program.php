<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    protected $fillable = [
        'PrgCode',
        'PrgDesc',
        'DateFunded',
        'Remarks',
        'UserRefCd',
        'BegDate',
        'EndDate',
    ];

    public $timestamps = false; // Unless you want `created_at`, `updated_at`
}
