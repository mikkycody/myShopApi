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
        'user_id','reference', 'total', 'status',
    ];

    /**
     * Order to user relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order to items relationship
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
