<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
    ];

    /**
     * Order to cart relationship
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

}
