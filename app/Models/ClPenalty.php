<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClPenalty extends Model
{
    protected $table = 'clpenalty';

    protected $fillable = [
        'CLKey',
        'GracePeriod',
        'EColChargePenalty',
        'EColPenaltyType',
        'EColPenaltyRate',
        'EColPenaltyBasis',
        'EColPenaltyFreq',
        'EColIncInterest',
        'AfMatChargePenalty',
        'AfMatPenaltyType',
        'AfMatPenaltyRate',
        'AfMatPenaltyBasis',
        'AfMatPenaltyFreq',
        'AfMatIncInterest',
        'PenaltyRateBasis',
    ];
}
