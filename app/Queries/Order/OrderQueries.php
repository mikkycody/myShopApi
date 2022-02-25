<?php

namespace App\Queries\Order;

use App\Models\Order;
use App\Queries\Product\ProductQueries;

class OrderQueries
{
    public static function generateReference()
    {
        return 'ORD-' . uniqid(time());
    }
}
