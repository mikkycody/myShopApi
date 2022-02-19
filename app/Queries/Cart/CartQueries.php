<?php

namespace App\Queries\Cart;

use App\Models\Cart;
use App\Models\Product;

class CartQueries
{
    public static function findCartProduct($cart_id, $product_id){
        return Cart::findOrFail($cart_id)->products()->where('product_id', $product_id)->firstWhere();
    }
}
