<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatLinksModel extends Model
{
    protected $fillable = [
        'category_id',
        'blog_id',
    ];
}
