<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogsModel extends Model
{
    // public $timestamps = true; 

    protected $primaryKey = 'blog_id';

    protected $fillable = [

        'blog_title',
        'blog_description',
        'blog_slug',
        'blog_content',
        'blog_tags',
        'blog_image',
        'image_alt_text',
        'meta_title',
        'meta_description',
        'shedule_date',
        'shedule_time',
        'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(BlogsCategories::class, 'cat_links', 'blog_id', 'category_id')->withPivot('status')
            ->withTimestamps(); 
    }
}
