<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use Exception;

class OrderController extends Controller
{
    public function store(OrderRequest $request){
        try{
            $order = $request->user()->orders()->create([
                'reference' => $request->reference,
                'total' => $request->total,
                'status' => false
            ]);
            $order->products()->attach($request->products);
            return $this->res(201, true, 'Order Created Successfully', new OrderResource($order));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
