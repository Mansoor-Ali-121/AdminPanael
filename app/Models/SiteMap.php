<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    protected $primaryKey = 'sitemap_id';

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

// SiteMap.php model
public function alternates()
{
    return $this->hasMany(AlternatePageModel::class, 'sitemap_id', 'sitemap_id');
}

}
