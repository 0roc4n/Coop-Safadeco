<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasaSavingsProduct extends Model
{
    protected $table = 'casasavingsproduct';

    protected $fillable = [
        'GroupCode',
        'SavingsCode',
    ];
}
