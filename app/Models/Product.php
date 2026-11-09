<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by_user_id',
        'title',
        'slug',
        'sku',
        'category',
        'default_price',
        'description',
        'default_thumbnail',
        'status',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
    ];

    /**
     * User who originally created this product in the shared catalog (Admin or Shop Owner)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * All shops listing this product
     */
    public function shopProducts()
    {
        return $this->hasMany(ShopProduct::class, 'product_id');
    }

    /**
     * Shops that have this product
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'shop_products')
                    ->withPivot('id', 'custom_price', 'custom_title', 'custom_description', 'custom_thumbnail', 'stock', 'is_available')
                    ->withTimestamps();
    }
}

