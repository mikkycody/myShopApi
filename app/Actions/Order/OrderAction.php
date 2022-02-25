<?php

namespace App\Actions\Order;

use App\Queries\Order\OrderQueries;
use App\Queries\Product\ProductQueries;
use Illuminate\Support\Facades\DB;

class OrderAction
{
    public static function create()
    {
        DB::beginTransaction();
        $total = self::calculateTotal();
        $order = request()->user()->orders()->create([
            'reference' => OrderQueries::generateReference(),
            'total' => $total,
            'status' => true
        ]);
        self::storeItems($order->id);
        DB::commit();
        return $order;
    }

    public static function calculateTotal()
    {
        $total = 0;
        foreach (request()->products as $product) {
            $price = ProductQueries::find($product['id'])->price;
            $total += $product['quantity'] * $price;
        }
        return $total;
    }

    public static function storeItems($id)
    {
        $items = [];
        foreach (request()->products as $product) {
            $items[] = [
                'order_id' => $id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ];
        }
        DB::table('order_items')->insert($items);
        return $items;
    }
}
