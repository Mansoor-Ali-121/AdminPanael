<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesModel extends Model
{

    protected $fillable = [
        'service_name',
        'service_slug',
        // 'actual_slug',
        'booking_link',
        'booking_page',
        'description',
        'service_image',
    ];
}
