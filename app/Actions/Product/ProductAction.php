<?php
namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductAction {
    public static function store(){
        DB::beginTransaction();
        $response = Auth::user()->products()->save(new Product([
            'name' => request()->name,
            'price' => request()->price,
        ]));
        DB::commit();
        return $response;
    }
}