<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public $cartservice;
    public function __construct(CartService $cartservice)
    {  
        $this->cartservice = $cartservice;
      }
    public function addToCart(CartRequest $request)
    {
        $request->validated();
        try{
            $cart = $this->cartservice->addToCart($request);
            if($cart == null){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Course already added to cart'
                ]);
            }
            return response()->json([
                'status'=>'success',
                'message'=>'Course added to cart successfully',
                'cart'=>$cart
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=> $e->getMessage()
            ]);
        }
    }

    public function index(){
        return view('frontend.pages.cart.index');
    }


    public function getCartItem(){
        $cart =  $this->cartservice->getCart();
        $subTotal = $this->cartservice->subtotal();
        $html = view('frontend.pages.cart.partial.main')->with(compact('cart','subTotal'))->render();
        return response()->json([
            'status'=>'success',
            'html'=>$html,
            'cookie_id'=>$this->cartservice->getCookieId()
        ]);
    }


    public function getAllCart(){
        try{
            $cart = $this->cartservice->getCart();
            $subTotal = $this->cartservice->subtotal();
            $html = view('frontend.pages.home.partials.cart')->with(compact('cart','subTotal'))->render();
            return response()->json([
                'status'=>'success',
                'html'=>$html,
                'cookie_id'=>$this->cartservice->getCookieId()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=> $e->getMessage()
            ]);
        }
    }




public function removeCartItem(Request $request){
    try{
        $cart = Cart::where('cookie_id', Cookie::get('cookie_id'))->where('course_id', $request->course_id)->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Cart removed successfully'
        ]);
    }catch(\Exception $e){
        return response()->json([
            'status'=>'error',
            'message'=> $e->getMessage()
        ]);
    }

}
}


/* 

Target class [App\Repository\CartService] does not exist.

*/