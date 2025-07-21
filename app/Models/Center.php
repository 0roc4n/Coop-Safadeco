<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'centers';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'CenterCode';

    // Disable auto-incrementing for the primary key since it's a string
    public $incrementing = false;

    // Specify the data type of the primary key
    protected $keyType = 'string';

    // Disable timestamps if your table does not have 'created_at' and 'updated_at' columns
    public $timestamps = false;

    // Define which attributes are mass assignable
    protected $fillable = [
        'CenterCode',
        'DateFormed',
        'Description',
        'Location',
        'Rank1',
        'Rank2',
        'Rank3',
        'FOfficer1',
        'FOfficer2',
    ];

    // Define attributes that should be cast to native types
    protected $casts = [
        'DateFormed' => 'datetime',
    ];
}
