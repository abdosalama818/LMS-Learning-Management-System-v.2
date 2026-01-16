<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    const CACHE_KEY_SUB = 'categories_with_subs';
    const CACHE_KEY_COURSES = 'course_category_with_courses';
    const CACHE_KEY_ALL_CATEGORIES = 'categories';

    public static function booted()
    {
        static::observe(CategoryObserver::class);
        $clearCache = function () {
            Cache::forget(self::CACHE_KEY_SUB);
            Cache::forget(self::CACHE_KEY_COURSES);
            Cache::forget(self::CACHE_KEY_ALL_CATEGORIES);
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }
}
