<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanPenalty extends Model
{
    protected $table = 'savingsplanpenalty';
    protected $primaryKey = 'SavPenID';

    protected $fillable = [
        'Fee', 'Surcharge', 'LapseTerm', 'LapseFreq',
        'GraceTerm', 'GraceFreq', 'EffectivityDate',
        'PolPenID'
    ];

    public function policyPenalty()
    {
        return $this->belongsTo(SavingsPlanPolicyPenalty::class, 'PolPenID');
    }
}
