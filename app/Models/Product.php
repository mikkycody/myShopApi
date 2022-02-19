<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
    ];

    /**
     * Product to user relationship
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Product to cart relationship
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }
}