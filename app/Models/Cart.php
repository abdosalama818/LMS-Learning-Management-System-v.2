<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    
    public static function booted()
    {
        static::creating(function ($cart) {
            $cart->id = (string) Str::uuid();
        });
    }



    public function user(){
      return  $this->belongsTo(User::class)->withDefault([
        'name'=>"anynomous"
      ]);
    }

      public function course(){
      return  $this->belongsTo(Course::class);
    }

}
