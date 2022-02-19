<?php

namespace App\Http\Controllers\Api;

use App\Actions\Product\ProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Queries\Product\ProductQueries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(["store"]);
    }

    public function store(CreateProductRequest $request)
    {
        try {
            $product = ProductAction::store();
            return $this->res(201, true, 'Product Created Successfully', new ProductResource($product));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $products = ProductQueries::all();
            return new ProductCollection($products);
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = ProductQueries::find($id);
            return $this->res(200, true, 'Product Retrieved Successfully', new ProductResource($product));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
