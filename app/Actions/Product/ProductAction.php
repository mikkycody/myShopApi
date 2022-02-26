<?php
namespace App\Actions\Product;

use App\Models\Product;
use App\Models\RemovedItem;
use Illuminate\Support\Facades\Auth;

class ProductAction {
    public static function store(){
        $response = Auth::user()->products()->save(new Product([
            'name' => request()->name,
            'price' => request()->price,
        ]));
        return $response;
    }

    public static function remove(){
        RemovedItem::create([
            'user_id' => Auth::id(),
            'product_id' => request()->product_id,
        ]);
    }
}