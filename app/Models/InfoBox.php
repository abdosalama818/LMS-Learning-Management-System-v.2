<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class InfoBox extends Model
{
    protected $guarded = [];

      const CACHE_KEY1 = 'info_first';
      const CACHE_KEY2 = 'info_second';
      const CACHE_KEY3 = 'info_third';

   protected static function booted()
{
    static::saved(function () {
        Cache::forget(self::CACHE_KEY1);
        Cache::forget(self::CACHE_KEY2);
        Cache::forget(self::CACHE_KEY3);
    });

    static::deleted(function () {
        Cache::forget(self::CACHE_KEY1);
        Cache::forget(self::CACHE_KEY2);
        Cache::forget(self::CACHE_KEY3);
    });
}
}
