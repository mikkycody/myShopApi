<?php

namespace App\Queries\Product;

use App\Models\Product;
use App\Models\RemovedItem;

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
        return RemovedItem::latest()->paginate(10);
    }
}
