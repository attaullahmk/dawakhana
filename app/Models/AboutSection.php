<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'vision_title',
        'vision_heading',
        'vision_description_1',
        'vision_description_2',
        'vision_image',
        'founder_name',
        'founder_title',
        'founder_image',
        'stats',
    ];

    protected $casts = [
        'stats' => 'array',
    ];

    public function scopeForLocale($query, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $query->where('locale', $locale);
    }
}
