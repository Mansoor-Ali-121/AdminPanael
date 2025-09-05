<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    protected $fillable = [

        'url',
        'canonical',
        'priority',
        'schema',
        'meta_title',
        'meta_description',
        'status',
        'pagecontent'
        
    ];
}
