<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Queries\Cart\CartQueries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartAction
{
    public static function create()
    {
        DB::beginTransaction();
        $response = Cart::create([
            'user_id' => Auth::id()
        ]);
        DB::commit();
        return $response;
    }

    public static function add()
    {
        DB::beginTransaction();
        $response = Cart::find(request()->cart_id)->products()->attach(request()->product_id);
        DB::commit();
        return $response;
    }

    public static function removeFromCart()
    {
        DB::beginTransaction();
        $response =  CartQueries::deleteCartProduct(request()->cart_id, request()->product_id);
        DB::commit();
        return $response;
    }

    public static function checkout()
    {
        DB::beginTransaction();
        $response = Order::create([
            'cart_id' => request()->cart_id
        ]);
        DB::commit();
        return $response;
    }
}
