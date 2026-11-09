<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ShopProduct;

class VendorController extends Controller
{
    /**
     * Helper to get current authenticated shop owner's shop
     */
    private function getShopForUser(Request $request)
    {
        $user = $request->user();
        $shop = Shop::where('user_id', $user->id)->first();

        if (!$shop) {
            // Auto create a shop for owner if none exists
            $shop = Shop::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Shop",
                'slug' => Str::slug($user->name . ' Shop') . '-' . Str::random(4),
                'description' => 'Welcome to our shop! Explore our quality products.',
                'status' => 'active',
            ]);
        }

        return $shop;
    }

    /**
     * Get Shop Owner's Shop Profile and summary stats
     */
    public function getMyShop(Request $request)
    {
        $shop = $this->getShopForUser($request);
        
        $totalListings = ShopProduct::where('shop_id', $shop->id)->count();
        $activeListings = ShopProduct::where('shop_id', $shop->id)->where('is_available', true)->count();
        $totalCatalog = Product::where('status', 'active')->count();

        return response()->json([
            'shop' => $shop,
            'stats' => [
                'total_listings' => $totalListings,
                'active_listings' => $activeListings,
                'available_in_catalog' => $totalCatalog,
            ]
        ]);
    }

    /**
     * Update Shop Profile
     */
    public function updateMyShop(Request $request)
    {
        $shop = $this->getShopForUser($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:shops,slug,' . $shop->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'banner' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $shop->update($validated);
        return response()->json(['message' => 'Shop profile updated successfully', 'shop' => $shop]);
    }

    /**
     * Products listed in this shop
     */
    public function getMyProducts(Request $request)
    {
        $shop = $this->getShopForUser($request);

        $query = ShopProduct::with(['product.creator'])
            ->where('shop_id', $shop->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('custom_title', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($p) use ($search) {
                      $p->where('title', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        $listings = $query->latest()->get();
        return response()->json($listings);
    }

    /**
     * Browse the Shared Product Catalog
     */
    public function getCatalog(Request $request)
    {
        $shop = $this->getShopForUser($request);

        $query = Product::with('creator')->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();

        // Map which products are already added to this shop
        $myProductIds = ShopProduct::where('shop_id', $shop->id)->pluck('id', 'product_id')->toArray();

        $result = $products->map(function ($product) use ($myProductIds) {
            $product->is_added_to_shop = isset($myProductIds[$product->id]);
            $product->shop_product_id = $myProductIds[$product->id] ?? null;
            return $product;
        });

        return response()->json($result);
    }

    /**
     * Add a product from shared catalog to this shop
     */
    public function addProductToShop(Request $request)
    {
        $shop = $this->getShopForUser($request);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'custom_price' => 'nullable|numeric|min:0',
            'custom_title' => 'nullable|string|max:255',
            'custom_description' => 'nullable|string',
            'custom_thumbnail' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $existing = ShopProduct::where('shop_id', $shop->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existing) {
            return response()->json(['message' => 'This product is already in your shop listing.'], 422);
        }

        $listing = ShopProduct::create([
            'shop_id' => $shop->id,
            'product_id' => $validated['product_id'],
            'custom_price' => $validated['custom_price'] ?? null,
            'custom_title' => $validated['custom_title'] ?? null,
            'custom_description' => $validated['custom_description'] ?? null,
            'custom_thumbnail' => $validated['custom_thumbnail'] ?? null,
            'stock' => $validated['stock'] ?? 50,
            'is_available' => true,
        ]);

        return response()->json([
            'message' => 'Product successfully added to your shop!',
            'listing' => $listing->load('product'),
        ], 201);
    }

    /**
     * Update shop-specific pricing, details, or thumbnail
     */
    public function updateShopProduct(Request $request, $id)
    {
        $shop = $this->getShopForUser($request);

        $listing = ShopProduct::where('shop_id', $shop->id)->findOrFail($id);

        $validated = $request->validate([
            'custom_price' => 'nullable|numeric|min:0',
            'custom_title' => 'nullable|string|max:255',
            'custom_description' => 'nullable|string',
            'custom_thumbnail' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
        ]);

        $listing->update($validated);

        return response()->json([
            'message' => 'Shop product details updated successfully!',
            'listing' => $listing->fresh()->load('product'),
        ]);
    }

    /**
     * Remove product from shop
     */
    public function removeProductFromShop(Request $request, $id)
    {
        $shop = $this->getShopForUser($request);
        $listing = ShopProduct::where('shop_id', $shop->id)->findOrFail($id);
        $listing->delete();

        return response()->json(['message' => 'Product removed from your shop.']);
    }

    /**
     * Shop Owner creates a new product:
     * Added to the shared catalog AND automatically added to their shop!
     */
    public function createProduct(Request $request)
    {
        $shop = $this->getShopForUser($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category' => 'nullable|string|max:100',
            'default_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'default_thumbnail' => 'nullable|string',
            // Optional initial shop customizations
            'custom_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        // 1. Create in Shared Catalog
        $product = Product::create([
            'created_by_user_id' => $request->user()->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(4),
            'sku' => $validated['sku'] ?? ('SKU-' . strtoupper(Str::random(8))),
            'category' => $validated['category'] ?? 'General',
            'default_price' => $validated['default_price'],
            'description' => $validated['description'] ?? null,
            'default_thumbnail' => $validated['default_thumbnail'] ?? null,
            'status' => 'active',
        ]);

        // 2. Automatically list in this Shop Owner's Shop
        $listing = ShopProduct::create([
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'custom_price' => !empty($validated['custom_price']) ? $validated['custom_price'] : null,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => $validated['stock'] ?? 50,
            'is_available' => true,
        ]);

        return response()->json([
            'message' => 'Product created and added to the Shared Catalog & your shop listing!',
            'product' => $product,
            'listing' => $listing->load('product'),
        ], 201);
    }
}

