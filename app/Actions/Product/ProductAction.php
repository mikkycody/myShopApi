<?php
namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductAction {
    public static function store(){
        DB::beginTransaction();
        return Auth::user()->products()->save(new Product([
            'name' => request()->name,
            'price' => request()->price,
        ]));
        DB::commit();
    }

    public static function find($id){
        return Product::findOrFail($id);
    }
}