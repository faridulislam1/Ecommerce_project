<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ShopProduct;

class AdminController extends Controller
{
    /**
     * Dashboard statistics for Admin
     */
    public function stats()
    {
        return response()->json([
            'total_shops' => Shop::count(),
            'total_products' => Product::count(),
            'total_owners' => User::where('role', 'shop_owner')->count(),
            'total_shop_listings' => ShopProduct::count(),
            'recent_shops' => Shop::with('owner')->latest()->take(5)->get(),
            'recent_products' => Product::with('creator')->latest()->take(5)->get(),
        ]);
    }

    // ==========================================
    // SHOPS CRUD
    // ==========================================

    public function getShops(Request $request)
    {
        $query = Shop::with('owner')->withCount('shopProducts');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    public function storeShop(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shops,slug',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'banner' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        }

        $shop = Shop::create($validated);
        return response()->json(['message' => 'Shop created successfully', 'shop' => $shop->load('owner')], 201);
    }

    public function updateShop(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:shops,slug,' . $shop->id,
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'banner' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $shop->update($validated);
        return response()->json(['message' => 'Shop updated successfully', 'shop' => $shop->load('owner')]);
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return response()->json(['message' => 'Shop deleted successfully']);
    }

    // ==========================================
    // SHARED PRODUCT CATALOG CRUD
    // ==========================================

    public function getProducts(Request $request)
    {
        $query = Product::with('creator')->withCount('shopProducts');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category' => 'nullable|string|max:100',
            'default_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'default_thumbnail' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        $validated['created_by_user_id'] = $request->user()->id;

        $product = Product::create($validated);
        return response()->json(['message' => 'Catalog product created successfully', 'product' => $product->load('creator')], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category' => 'nullable|string|max:100',
            'default_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'default_thumbnail' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Product updated successfully', 'product' => $product->load('creator')]);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product removed from catalog successfully']);
    }

    // ==========================================
    // SHOP OWNERS CRUD
    // ==========================================

    public function getOwners(Request $request)
    {
        $query = User::where('role', 'shop_owner')->with('shop');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    public function storeOwner(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:50',
            'shop_id' => 'nullable|exists:shops,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'shop_owner',
            'phone' => $validated['phone'] ?? null,
        ]);

        if (!empty($validated['shop_id'])) {
            $shop = Shop::find($validated['shop_id']);
            if ($shop) {
                $shop->user_id = $user->id;
                $shop->save();
            }
        }

        return response()->json(['message' => 'Shop Owner account created successfully', 'owner' => $user->load('shop')], 201);
    }

    public function updateOwner(Request $request, $id)
    {
        $owner = User::where('role', 'shop_owner')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $owner->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:50',
            'shop_id' => 'nullable|exists:shops,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $owner->update($updateData);

        // Update shop assignment if provided
        if (isset($validated['shop_id'])) {
            // Unassign previous shop
            Shop::where('user_id', $owner->id)->update(['user_id' => null]);
            if ($validated['shop_id']) {
                $newShop = Shop::find($validated['shop_id']);
                if ($newShop) {
                    $newShop->user_id = $owner->id;
                    $newShop->save();
                }
            }
        }

        return response()->json(['message' => 'Shop Owner updated successfully', 'owner' => $owner->fresh()->load('shop')]);
    }

    public function deleteOwner($id)
    {
        $owner = User::where('role', 'shop_owner')->findOrFail($id);
        // Unlink shop if any
        Shop::where('user_id', $owner->id)->update(['user_id' => null]);
        $owner->delete();
        return response()->json(['message' => 'Shop Owner account deleted successfully']);
    }
}

