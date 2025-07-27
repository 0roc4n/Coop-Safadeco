<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenaltyDue extends Model
{
    protected $table = 'penalty_dues';

    protected $fillable = [
        'clkey',
        'datedue',
        'penaltydue',
    ];
}
