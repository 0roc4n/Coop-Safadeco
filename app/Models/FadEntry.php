<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaDentry extends Model {
    protected $table = 'fadentries';

    protected $fillable = [
        'FAKey', 'Period', 'AcctCode', 'Debit', 'Credit',
        'RefTransCode', 'ItemKey', 'DepDate',
    ];
}
