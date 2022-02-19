<?php

namespace App\Queries\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\Product;

class CartQueries
{
    public static function findCartProduct($cart_id, $product_id){
        return CartProduct::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
    }

    public static function deleteCartProduct($cart_id, $product_id)
    {
        return CartProduct::where('cart_id', $cart_id)->where('product_id', $product_id)->delete();
    }

    public static function find($id){
        return Cart::find($id);
    }

    public static function checkedOut($id) {
        return Order::firstWhere('cart_id', $id);
    }
}
