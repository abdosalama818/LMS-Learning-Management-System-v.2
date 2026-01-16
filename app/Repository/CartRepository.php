<?php

namespace App\Repository;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartRepository
{


    
public function createCart($cookie_id , $course_id,$qty){

      $cart=  Cart::create([
                'cookie_id' => $cookie_id,
                'course_id' => $course_id,
                'user_id' => auth('web')->user()->id ?? null,
                'qty' => $qty,
            ]);
            return $cart;
}

    public function incrementQty(Cart $cart, $qty)
    {
        return $cart->increment('qty', $qty);
    }

    public function clearCart()
{
    $cookie_id = $this->getCookieId();

    return Cart::where('cookie_id', $cookie_id)->delete();
}

       public function getCookieId()
    {
        $cookie_id = Cookie::get('cookie_id');

        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cookie_id', $cookie_id, 60 * 24 * 30);
        }

        return $cookie_id;
    }


    public function deleteCourse($cart){
        return $cart->delete();
    }

    public function updateCartQty($cart,$qty){
        return $cart->update([
               'qty' => max(1, (int) $qty),
        ]);
    }

 
}
