<?php

namespace App\Facade;

use App\Services\CartService;
use Illuminate\Support\Facades\Facade;

class CartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartService::class;
    }
}