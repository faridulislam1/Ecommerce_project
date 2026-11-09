<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'phone',
        'address',
        'status',
    ];

    /**
     * The owner of this shop
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The shop product listings
     */
    public function shopProducts()
    {
        return $this->hasMany(ShopProduct::class, 'shop_id');
    }

    /**
     * Catalog products linked to this shop
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'shop_products')
                    ->withPivot('id', 'custom_price', 'custom_title', 'custom_description', 'custom_thumbnail', 'stock', 'is_available')
                    ->withTimestamps();
    }
}

