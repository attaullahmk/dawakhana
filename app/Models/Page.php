<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'system_key',
        'title',
        'content',
        'locale',
        'is_active',
    ];

    public function scopeForLocale($query)
    {
        return $query->where('locale', app()->getLocale());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
