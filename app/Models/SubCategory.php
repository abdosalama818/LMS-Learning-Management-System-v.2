<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function name(): Attribute //to store slug in DB Mutators
    {
        return Attribute::make(
            set: function ($value) {
                return [
                    'name' => $value,
                    'slug' => Str::slug($value),
                ];
            }
        );
    }



        const CACHE_KEY = 'categories_with_subs';

    public static function booted()
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }
}
