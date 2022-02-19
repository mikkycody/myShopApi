<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User to roles relationship
     */

     public function roles(){
        return $this->belongsToMany(Role::class);
     }

    /**
     * User to products relationship
     */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * User to carts relationship
     */

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

     /** Check if user has a role of an admin */
     public function isAdmin(){
        return $this->roles()->where('name', 'Admin')->exists() == true;
     }

    /** Check if user has a role of user */
    public function isNormalUser()
    {
        return $this->roles()->where('name', 'User')->exists() == true;
    }

    /** Check if user has a role of sales rep */
    public function isSalesRep()
    {
        return $this->roles()->where('name', 'Sales Representative')->exists() == true;
    }
}
