<?php

namespace App\Http\Controllers\Api;

use App\Actions\Cart\CartAction;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(["store"]);
    }

    public function store()
    {
        try {
            return $this->res(201, true, 'Cart Created', CartAction::create());
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
