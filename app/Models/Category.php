<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;

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

    public static function booted()
    {
        static::observe(CategoryObserver::class);
    }
}
