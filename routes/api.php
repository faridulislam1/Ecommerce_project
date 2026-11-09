<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\UploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/login', [AuthController::class, 'login']);

// Customer Public Endpoints (Strictly Shop-scoped)
Route::prefix('customer')->group(function () {
    Route::get('/shops', [CustomerController::class, 'getShops']);
    Route::get('/shops/{slug}', [CustomerController::class, 'getShopStorefront']);
    Route::get('/shops/{slug}/products/{productId}', [CustomerController::class, 'getShopProductDetail']);
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload', [UploadController::class, 'uploadImage']);

    // Admin Panel Routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'stats']);

        // Shops CRUD
        Route::get('/shops', [AdminController::class, 'getShops']);
        Route::post('/shops', [AdminController::class, 'storeShop']);
        Route::put('/shops/{id}', [AdminController::class, 'updateShop']);
        Route::delete('/shops/{id}', [AdminController::class, 'deleteShop']);

        // Shared Catalog Products CRUD
        Route::get('/products', [AdminController::class, 'getProducts']);
        Route::post('/products', [AdminController::class, 'storeProduct']);
        Route::put('/products/{id}', [AdminController::class, 'updateProduct']);
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct']);

        // Shop Owners CRUD
        Route::get('/owners', [AdminController::class, 'getOwners']);
        Route::post('/owners', [AdminController::class, 'storeOwner']);
        Route::put('/owners/{id}', [AdminController::class, 'updateOwner']);
        Route::delete('/owners/{id}', [AdminController::class, 'deleteOwner']);
    });

    // Shop Owner (Vendor) Routes
    Route::prefix('vendor')->middleware('role:shop_owner,admin')->group(function () {
        Route::get('/shop', [VendorController::class, 'getMyShop']);
        Route::put('/shop', [VendorController::class, 'updateMyShop']);

        Route::get('/my-products', [VendorController::class, 'getMyProducts']);
        Route::put('/my-products/{id}', [VendorController::class, 'updateShopProduct']);
        Route::delete('/my-products/{id}', [VendorController::class, 'removeProductFromShop']);

        Route::get('/catalog', [VendorController::class, 'getCatalog']);
        Route::post('/add-to-shop', [VendorController::class, 'addProductToShop']);
        Route::post('/create-product', [VendorController::class, 'createProduct']);
    });
});
