<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DbSetting extends Model
{
    protected $table = 'dbsettings';
    protected $primaryKey = 'SettingID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'SettingID',
        'SettingName',
        'SettingValue',
        'SettingDesc',
        'SettingIndex',
        'DisplayTag',
    ];
}
