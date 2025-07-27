<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanPolicy extends Model
{
    protected $table = 'savingsplanpolicy';
    protected $primaryKey = 'PolicyID';

    protected $fillable = [
        'Title', 'GrossValue', 'Frequency', 'PolicyTerm',
        'PolicyRate', 'EffectivityDate', 'RegularRate',
        'ExtendedTerm', 'ExtendedRate', 'SavID', 
        'PolPenID', 'MOP', 'intMOP', 'MinDep', 'FilingFee',
        'ShareCapital', 'SubFee'
    ];

}
