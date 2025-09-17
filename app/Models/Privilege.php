<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'can_read',
        'can_update',
        'can_add',
        'can_delete',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
