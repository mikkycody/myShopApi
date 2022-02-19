<?php

namespace App\Queries\Product;

use App\Models\CartProduct;
use App\Models\Product;

class ProductQueries
{
    public static function find($id)
    {
        return Product::find($id);
    }

    public static function all()
    {
        return Product::latest()->paginate(10);
    }

    public static function removedItems()
    {
        return Product::whereIn('id' , CartProduct::onlyTrashed()->pluck('product_id'))->paginate(10);
    }

    public static function checkRecord($cart_id, $product_id){
        return CartProduct::where('cart_id', $cart_id)->where('product_id', $product_id)->exists() === false;
    }
}
