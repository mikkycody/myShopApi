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
        return Product::whereIn('id' , CartProduct::where('deleted_at', '!==', null)->pluck('product_id'))->paginate(10);
    }
}
