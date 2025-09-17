<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLoanRatings extends Model
{
    protected $fillable = [
        'LACode',
        'RatingsCode',
        'RatingsValue',
        'RatingScore',
        'DateRated',
    ];

    public function loanApplication(): BelongsTo
    {
        return $this->belongsTo(LoanApplication::class, 'LACode', 'LACode');
    }
}
