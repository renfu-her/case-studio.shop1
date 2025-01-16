<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'site_name',
        'title',
        'description',
        'keywords',
        'og_image',
        'ga_id',
        'gtm_id',
        'custom_tags',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
