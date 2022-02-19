<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Cart to user relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Cart to product relationship
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
