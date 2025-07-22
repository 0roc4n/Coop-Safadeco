<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CIFClientele extends Model
{
    protected $primaryKey = 'c_i_f_clienteles';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CIFKey',
        'ClientCode',
        'DateEncoded',
        'UpdateStatus',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
