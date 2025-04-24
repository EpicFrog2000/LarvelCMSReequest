<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class site_settings extends Model
{
    protected $table = 'site_settings';
    protected $fillable = [
        'nazwa',
        'value',
    ];
    protected $casts = [
        'nazwa' => 'string',
        'value' => 'string',
    ];
}
