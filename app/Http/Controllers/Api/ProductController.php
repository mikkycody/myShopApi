<?php

namespace App\Http\Controllers\Api;

use App\Actions\Product\ProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\RemoveProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RemovedItemCollection;
use App\Queries\Product\ProductQueries;
use Exception;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(["store", "removedProducts", "remove"]);
    }

    /**
     * Store new product.
     * @param  \App\Http\Requests\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
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
            return new ProductCollection(ProductQueries::all());
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = ProductQueries::find($id);
            if (!$product) {
                return $this->res(400, false, 'Product not found.');
            }
            return $this->res(200, true, 'Product Retrieved Successfully', new ProductResource($product));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    /**
     * remove product.
     * @param  \App\Http\Requests\RemoveProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function remove(RemoveProductRequest $request)
    {
        try {
            ProductAction::remove();
            return $this->res(200, true, 'Product Removed Successfully.');
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    public function removedProducts()
    {
        try {
            return new RemovedItemCollection(ProductQueries::removedItems());
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }
}
