<?php

namespace App\Services;

use App\Models\Cart;
use App\Repository\CartRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartService
{

public $cartRepository;
public function __construct(CartRepository $cartRepository)
{
    $this->cartRepository = $cartRepository;
}

    public function getCart() :Collection
    {
        $cookie_id = $this->getCookieId();
        $cart = Cart::where('cookie_id', $cookie_id)->with('course')->get();
        return $cart;
    }

    public function addToCart($request)
    {
        $cookie_id = $this->getCookieId();
        $cart = Cart::where('cookie_id', $cookie_id)->where('course_id', $request->course_id)->first();

        if ($cart) {
           return null;
        } else {
            $cart = $this->cartRepository->createCart($cookie_id , $request->course_id,$request->quantity);
      
        }
        return $cart;
    }

    public function removeCourse(CartRepository $cartRepository,$course_id)
    {
        $cookie_id = $this->getCookieId();
        $cart = Cart::where('cookie_id', $cookie_id)->where('course_id', $course_id)->first();
        if ($cart) {
            $cartRepository->deleteCourse($cart);
        }
        return $cart;
    }

public function clearCart()
{
    $cookie_id = $this->getCookieId();

    return Cart::where('cookie_id', $cookie_id)->delete();
}

    public function updateCartQty($course_id , $qty , CartRepository $cartRepository)
    {
        $cookie_id = $this->getCookieId();
        $cart = Cart::where('cookie_id', $cookie_id)->where('course_id', $course_id)->first();
        if ($cart) {
            $cartRepository->updateCartQty($cart , $qty);
        }
        return $cart;
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

    public function subtotal(){
        $cookie_id = $this->getCookieId();
        $cart = Cart::where('cookie_id', $cookie_id)->with('course')->get();
        $subtotal = $cart->sum('course.discount_price');
        return $subtotal;
    }
}