<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiaries extends Model
{
    use HasFactory;

    protected $primaryKey = 'BenID';
    public $incrementing = true;

    protected $fillable = [
        'ClientCode',
        'Name',
        'Age',
        'Relationship',
        'IsBeneficiary',
        'IsDependent',
        'BirthDate',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
