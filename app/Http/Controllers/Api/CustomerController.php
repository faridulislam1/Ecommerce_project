<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopProduct;

class CustomerController extends Controller
{
    /**
     * List all active shops for customers to discover
     */
    public function getShops(Request $request)
    {
        $query = Shop::where('status', 'active')
            ->withCount(['shopProducts' => function ($q) {
                $q->where('is_available', true);
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $shops = $query->latest()->get();
        return response()->json($shops);
    }

    /**
     * Get Shop details and ONLY the products assigned to this shop.
     * Enforces: "Customers should only see products assigned to a shop.
     * Display shop-specific product information, prices, and thumbnails.
     * Products that are not assigned to any shop must not be visible to customers."
     */
    public function getShopStorefront($slug, Request $request)
    {
        $shop = Shop::where('status', 'active')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)->orWhere('id', $slug);
            })
            ->firstOrFail();

        $query = ShopProduct::with('product')
            ->where('shop_id', $shop->id)
            ->where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('custom_title', 'like', "%{$search}%")
                  ->orWhere('custom_description', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($p) use ($search) {
                      $p->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $category = $request->category;
            $query->whereHas('product', function ($p) use ($category) {
                $p->where('category', $category);
            });
        }

        $listings = $query->latest()->get();

        // Map to customer-facing format with shop overrides
        $products = $listings->map(function ($item) {
            return [
                'shop_product_id' => $item->id,
                'product_id' => $item->product_id,
                'title' => $item->display_title,
                'price' => $item->display_price,
                'default_price' => (float) ($item->product ? $item->product->default_price : 0),
                'has_custom_price' => $item->custom_price !== null,
                'description' => $item->display_description,
                'thumbnail' => $item->display_thumbnail,
                'category' => $item->product ? $item->product->category : 'General',
                'sku' => $item->product ? $item->product->sku : null,
                'stock' => $item->stock,
                'is_available' => $item->is_available,
            ];
        });

        // Get unique categories available in this shop
        $categories = $listings->pluck('product.category')->filter()->unique()->values();

        return response()->json([
            'shop' => $shop,
            'products' => $products,
            'categories' => $categories,
            'total_products' => $products->count(),
        ]);
    }

    /**
     * Get specific product detail under a shop
     */
    public function getShopProductDetail($slug, $productId)
    {
        $shop = Shop::where('status', 'active')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)->orWhere('id', $slug);
            })
            ->firstOrFail();

        $listing = ShopProduct::with(['product.creator'])
            ->where('shop_id', $shop->id)
            ->where('is_available', true)
            ->where(function ($q) use ($productId) {
                $q->where('id', $productId)->orWhere('product_id', $productId);
            })
            ->firstOrFail();

        return response()->json([
            'shop' => $shop,
            'product' => [
                'shop_product_id' => $listing->id,
                'product_id' => $listing->product_id,
                'title' => $listing->display_title,
                'price' => $listing->display_price,
                'default_price' => (float) ($listing->product ? $listing->product->default_price : 0),
                'has_custom_price' => $listing->custom_price !== null,
                'description' => $listing->display_description,
                'thumbnail' => $listing->display_thumbnail,
                'category' => $listing->product ? $listing->product->category : 'General',
                'sku' => $listing->product ? $listing->product->sku : null,
                'stock' => $listing->stock,
                'creator_name' => $listing->product && $listing->product->creator ? $listing->product->creator->name : 'Platform',
            ]
        ]);
    }
}

