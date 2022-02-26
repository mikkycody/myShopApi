<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Item to product relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * Item to order relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
