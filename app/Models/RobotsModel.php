<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RobotsModel extends Model
{
    protected $fillable = [
        'allowed',
        'disallowed',
        'status',
    ];
}
