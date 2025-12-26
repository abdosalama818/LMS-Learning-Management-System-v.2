<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
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
}
