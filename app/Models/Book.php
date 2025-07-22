<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'FolderKey';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Description',
        'DateCreated',
        'DateFrom',
        'DateTo',
        'Closing',
        'Purging',
    ];
}
