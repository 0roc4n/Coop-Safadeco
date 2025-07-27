<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosMembership extends Model
{
    protected $table = 'pesosmembership';


    protected $fillable = [
        'MembershipYear',
        'MembershipMonth',
        'TargetMembers',
    ];
}
