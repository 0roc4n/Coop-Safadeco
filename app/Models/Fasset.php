<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaAsset extends Model {
    protected $table = 'fassets';
    protected $primaryKey = 'ItemKey';

    protected $fillable = [
        'ItemDesc', 'DateOfPurch', 'Quantity', 'TotalCost',
        'EstLife', 'ScrapValue', 'CMeth', 'TransCode', 'AcctCode',
        'Disposed', 'TransNo', 'SerialNo', 'InventoryNo',
    ];
}
