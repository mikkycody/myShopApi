<?php

namespace App\Http\Controllers\Api;

use App\Actions\Order\OrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use Exception;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store new order.
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            $order = OrderAction::create();
            return $this->res(201, true, 'Order Created Successfully', new OrderResource($order));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    /**
     * Checkout order.
     * @param  \App\Http\Requests\CheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */    public function checkout(CheckoutRequest $request)
    {
        try {
            OrderAction::checkout();
            return $this->res(200, true, 'Checkout Successful');
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
