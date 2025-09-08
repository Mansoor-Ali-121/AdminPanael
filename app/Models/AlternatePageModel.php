<?php

namespace App\Models;

use App\Models\SiteMap;
use Illuminate\Database\Eloquent\Model;

class AlternatePageModel extends Model
{
    protected $primaryKey = 'alternate_id';

   protected $fillable = [
    'sitemap_id',
    'hreflang',
    'href',
];

public function sitemap()
{
    return $this->belongsTo(SiteMap::class, 'sitemap_id');
}


}
