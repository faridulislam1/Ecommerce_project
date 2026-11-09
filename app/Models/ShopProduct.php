<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'product_id',
        'custom_price',
        'custom_title',
        'custom_description',
        'custom_thumbnail',
        'stock',
        'is_available',
    ];

    protected $casts = [
        'custom_price' => 'decimal:2',
        'is_available' => 'boolean',
        'stock' => 'integer',
    ];

    protected $appends = [
        'display_title',
        'display_price',
        'display_description',
        'display_thumbnail',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getDisplayTitleAttribute()
    {
        return !empty($this->custom_title) ? $this->custom_title : ($this->product ? $this->product->title : '');
    }

    public function getDisplayPriceAttribute()
    {
        if ($this->custom_price !== null && $this->custom_price !== '') {
            return (float) $this->custom_price;
        }
        return $this->product ? (float) $this->product->default_price : 0;
    }

    public function getDisplayDescriptionAttribute()
    {
        return !empty($this->custom_description) ? $this->custom_description : ($this->product ? $this->product->description : '');
    }

    public function getDisplayThumbnailAttribute()
    {
        return !empty($this->custom_thumbnail) ? $this->custom_thumbnail : ($this->product ? $this->product->default_thumbnail : null);
    }
}

