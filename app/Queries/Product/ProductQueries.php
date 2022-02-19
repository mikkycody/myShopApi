<?php

namespace App\Queries\Product;

use App\Models\Product;

class ProductQueries
{
    public static function find($id)
    {
        return Product::findOrFail($id);
    }

    public static function all()
    {
        return Product::latest()->paginate(10);
    }
}
