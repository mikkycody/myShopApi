<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartAction
{
    public static function create()
    {
        DB::beginTransaction();
        return Cart::create([
            'user_id' => Auth::id()
        ]);
        DB::commit();
    }

    public static function add()
    {
        DB::beginTransaction();
        return Cart::find(request()->cart_id)->products()->attach(request()->product_id);
        DB::commit();
    }

    public static function removeFromCart()
    {
        DB::beginTransaction();
        return Cart::find(request()->cart_id)->products()->where('product_id', request()->product_id)->delete();
        DB::commit();
    }
}
