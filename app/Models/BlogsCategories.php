<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogsCategories extends Model
{
    protected $primaryKey = 'category_id';
    protected $table = 'blogs_categories';

    protected $fillable = [
        'category_name',
        'category_slug',
        'category_status',
    ];
}
