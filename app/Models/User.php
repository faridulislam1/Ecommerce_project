<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isShopOwner(): bool
    {
        return $this->role === 'shop_owner';
    }

    /**
     * A shop owner has one shop (or can manage multiple shops, but typically 1 in standard multi-vendor)
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id');
    }

    /**
     * Products created by this user in the shared catalog
     */
    public function createdProducts()
    {
        return $this->hasMany(Product::class, 'created_by_user_id');
    }
}
