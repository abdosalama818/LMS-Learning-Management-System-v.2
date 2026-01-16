<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Facade\CartFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(){
        $cart = CartFacade::getCart();
        $total = CartFacade::subtotal();
        $user = auth('instructor')->user();
        return view('frontend.pages.checkout.index',compact('cart','total','user'));
    }
}
