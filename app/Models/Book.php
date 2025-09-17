<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'FolderKey';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Description',
        'DateCreated',
        'DateFrom',
        'DateTo',
        'Closing',
        'Purging',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'DateCreated' => 'datetime',
        'DateFrom' => 'datetime',
        'DateTo' => 'datetime',
        'Closing' => 'datetime',
        'Purging' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
