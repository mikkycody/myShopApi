<?php

namespace App\Http\Controllers\Api;

use App\Actions\Cart\CartAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CartResource;
use App\Queries\Cart\CartQueries;
use App\Queries\Product\ProductQueries;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store()
    {
        try {
            return $this->res(201, true, 'Cart Created', new CartResource(CartAction::create()));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function addToCart(AddToCartRequest $request)
    {
        try {
            if (CartQueries::checkedOut($request->cart_id))
                return $this->res(400, false, 'Order placed already.');
            if (!ProductQueries::checkRecord($request->cart_id, $request->product_id))
                return $this->res(400, false, 'This product has been added.');
            if (!ProductQueries::find($request->product_id))
                return $this->res(400, false, 'Product not found.');
            if (!Auth::user()->carts()->firstWhere('id', $request->cart_id))
                return $this->res(400, false, 'Cart not found.');
            return $this->res(200, true, 'Product Added', CartAction::add());
        }catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function removeFromCart(AddToCartRequest $request)
    {
        try {
            if (CartQueries::checkedOut($request->cart_id))
                return $this->res(400, false, 'Order placed already.');
            if (!CartQueries::findCartProduct($request->cart_id , $request->product_id))
                return $this->res(400, false, 'Product not found in cart.');
            CartAction::removeFromCart();
            return $this->res(200, true, 'Product Removed');
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function checkout(CheckoutRequest $request)
    {
        try {
            if (CartQueries::checkedOut($request->cart_id))
                return $this->res(400, false, 'Order placed already.');
            if (!$cart = CartQueries::find($request->cart_id))
                return $this->res(400, false, 'Cart not found.');
            if ($cart->products()->count() == 0)
                return $this->res(400, false, 'No product(s) found.');
            return $this->res(200, true, 'Checkout Successful', CartAction::checkout());
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
