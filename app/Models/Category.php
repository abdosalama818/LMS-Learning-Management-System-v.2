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
    
    const CACHE_KEY = 'categories_with_subs';

    public static function booted()
    {
        static::observe(CategoryObserver::class);
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }






}
